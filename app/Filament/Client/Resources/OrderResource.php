<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Currency;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShippingAddress;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Filament\Infolists\Contracts\HasInfolists;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\OrderResource\Pages;
use App\Filament\Client\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'icon-orders';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('order info')
                ->label(trans('dash.order_info'))
                ->schema([
                Forms\Components\TextInput::make('name')
                    ->label(trans('dash.name'))
                    ->required(),
                Forms\Components\KeyValue::make('vendor_info')
                    ->label(trans('dash.seller_info'))
                    ->hint(trans('dash.seller_info_hint')),
                Forms\Components\Select::make(name: 'shipping_address_id')
                    ->label(trans('dash.shipping_address'))
                    ->options(ShippingAddress::whereClientId(auth()->user()->client?->id)->pluck('full_address','id'))
                    ->preload()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('first_name')->label(trans('dash.first_name'))
                            ->required(),
                        Forms\Components\TextInput::make('last_name')->label(trans('dash.last_name'))
                            ->required(),
                        Forms\Components\TextInput::make('phone_number')->label(trans('dash.phone_number'))
                            ->hint('ex:+00155555555')
                            ->required()->tel()->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Forms\Components\Select::make('country')->label(trans('dash.country'))
                            ->searchable()
                            ->options(function () {
                                $response = Http::get('https://restcountries.com/v3.1/all');
                                $jsonData = $response->json();
                            
                                foreach($jsonData as $c)
                                {
                                    $countries[$c['flag']] = $c['name']['common'];
                                }
                                return $countries;
                    
                            }),
                        Forms\Components\TextInput::make('city')->label(trans('dash.city'))
                            ->required(),
                        Forms\Components\TextInput::make('zip_code')->label(trans('dash.zip_code'))->numeric()->length(5)
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        auth()->user()->client->shippingAddresses()->create($data)->getKey();
                        Notification::make()
                                    ->title(trans('dash.creation_success',['model'=>trans('dash.shipping_address')]))
                                    ->success()
                                    ->send();
                        
                    })
                    ->required(),
                Forms\Components\Select::make(name: 'currency_id')
                    ->label(trans('dash.currency'))
                    ->options(Currency::active()->pluck('symbol','id'))
                    ->preload()
                    ->required(),
                ]),
                Section::make('')
                    ->label(trans('dash.products_info'))
                    ->schema([
                    
                        Forms\Components\Repeater::make('products_info')
                         ->schema([
                            Forms\Components\Grid::make('')
                            ->columns(2)
                            ->schema([
                            Forms\Components\TextInput::make('name')
                                ->label(trans('dash.name'))
                                ->required(),
                            Forms\Components\TextInput::make('price')
                                ->label(trans('dash.price'))
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make('quantity')
                                ->label(trans('dash.quantity'))
                                ->numeric()
                                ->required(),
                            Forms\Components\TextInput::make(name: 'description')
                                ->label(trans('dash.description'))
                                ->columnSpanFull(),
                            Forms\Components\FileUpload::make(name: 'images')
                                ->label(trans('dash.images'))
                                ->multiple()
                                ->image()
                                ->directory('products')
                                ->columnSpanFull()
                            ])
                         ])
                ]),
                Repeater::make('containers')
                    ->required()
                    ->label(trans('dash.containers_count'))
                    ->columnSpanFull()
                    ->required()
                    ->schema(components: [
                        Grid::make('')
                            ->columns(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                ->label(trans('dash.container_type'))
                                ->options(
                                    ['big_container'=>trans('dash.big_container'),'medium_container'=>trans('dash.medium_container'),'small_container'=>trans('dash.small_container')]
                                )
                                ->required(),
                                Forms\Components\TextInput::make('count')
                                    ->label(trans('dash.containers_count'))
                                    ->numeric()
                                    ->required(),
                            ])
                    ]), 
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->query(Order::query()->whereClientId(request()->user()?->client->id))
            ->contentGrid([
                'md' => 1,
                'xl' => 1,
            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')->label(trans('dash.name'))->searchable(),
                    TextColumn::make('created_at')->label(trans('dash.order_date'))->searchable()->sortable(),
                    // TextColumn::make('currency.symbol')->label(trans('dash.currency')),
                    // TextColumn::make('status')->label(trans('dash.status'))
                    //         ->badge()
                    //         ->color(fn (string $state): string => match ($state) {
                    //             'pending' => 'gray',
                    //             'inspected' => 'warning',
                    //             'approved' => 'success',
                    //             'completed' => 'success',
                    //             'refunded' => 'danger',
                    //         }),
                    // TextColumn::make('expected_delivery_date')->label(trans('dash.expected_delivery_date'))->date(),
                    // TextColumn::make('real_delivery_date')->label(trans('dash.real_delivery_date'))->date(),
                    // TextColumn::make('payment_status')->label(trans('dash.payment_status'))
                    //         ->badge()
                    //         ->color(fn (string $state): string => match ($state) {
                    //             'Paid' => 'success',
                    //             'Not Paid' => 'warning',
                    //         })
                ]),
                View::make('filament.pages.tables.view-order'),
                
                // TextColumn::make('count(payments)')->label(trans('dash.payments'))
            ])
            ->filters([

                SelectFilter::make('status')->label(trans('dash.status'))->options([
                    'pending' => trans('dash.pending'),
                    'inspected' => trans('dash.inspected'),
                    'approved' => trans('dash.approved'),
                    'completed' => trans('dash.completed'),
                    'refunded' => trans('dash.refunded'),
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->hidden(fn(Order $order)=>$order->status !="pending"),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
           ;
    }
    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                    \Filament\Infolists\Components\Section::make(trans('dash.order_info'))
                        ->headerActions([
                            // Action::make(trans('dash.edit'))
                            //     ->url(fn (Student $record): string => route('filament.admin.resources.students.edit', $record))
                        ])
                        ->columns(2)
                        ->id('main-section')
                        ->schema([


                                TextEntry::make('name')->label(trans('dash.name'))->weight(FontWeight::Bold),
                                TextEntry::make( 'client.user.email')->label(trans('dash.email'))->weight(FontWeight::Bold),

                                TextEntry::make('expected_delivery_date')->label(trans('dash.expected_delivery_date'))->weight(FontWeight::Bold),
                                TextEntry::make('real_delivery_date')->label(trans('dash.real_delivery_date'))->weight(FontWeight::Bold),
                                TextEntry::make( 'shippingAddress.full_address')->label(trans('dash.address'))->weight(FontWeight::Bold),
                                TextEntry::make('containers_count')->label(trans('dash.containers_count'))->weight(FontWeight::Bold),
                                TextEntry::make('currency.name')->label(trans('dash.currency'))->weight(FontWeight::Bold),
                                TextEntry::make('status')->label(trans('dash.status'))->weight(FontWeight::Bold),
                                TextEntry::make(name: 'rejection_note')->label(trans('dash.rejection_note'))
                                ->hidden(fn(Order $order)=> $order->rejection_note == null)
                                ->weight(FontWeight::Bold),
                                TextEntry::make('created_at')->label(trans('dash.created_at'))->date()->weight(FontWeight::Bold),
                                ViewEntry::make('containers')->label(trans('dash.containers_count'))->view('infolists.components.containers-count'),
                        ]),
                    \Filament\Infolists\Components\Section::make(trans('dash.products_info'))
                        ->id('products_info-section')
                        ->schema([
                                
                                ViewEntry::make('products')->label(trans('dash.products_info'))->view('infolists.components.view-order-product'),

                    
                        ]),
                    \Filament\Infolists\Components\Section::make(trans('dash.status'))
                            ->id('status-section')
                            ->schema([
                                    
                                    ViewEntry::make('status')->label(trans('dash.quota_status'))->view('infolists.components.view-order-status'),

                        
                            ]),
                    \Filament\Infolists\Components\Section::make(trans('dash.order_discussion'))
                            ->id('discussion-section')
                            ->schema([
                                    
                                    ViewEntry::make('discussion')->label(trans('dash.order_discussion'))->view('infolists.components.view-order-discussion'),

                        
                            ]),
                // \Filament\Infolists\Components\Section::make(trans('dash.account_ballance'))
                //         ->columns(2)
                //         ->id('account_ballance-section')
                //         ->schema([
                //                 TextEntry::make('balance')->label(trans('dash.account_ballance_actual'))
                //                 ->color('primary')
                //                 ->size(TextEntry\TextEntrySize::Large)
                //                 ->weight(FontWeight::Bold)
                //                 ->tooltip(function (TextEntry $component): ?string {
                                    
                //                     return trans('dash.balance_calculate_method');
                //                 })
                       
                //         ]),
                       
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
