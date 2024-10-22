<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Currency;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ShippingAddress;
use Filament\Resources\Resource;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\Stack;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\OrderResource\Pages;
use App\Filament\Client\Resources\OrderResource\RelationManagers;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Filters\SelectFilter;

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
                            Forms\Components\FileUpload::make(name: 'thumbnail')
                                ->label(trans('dash.thumbnail'))
                                ->image()
                                ->directory('products')
                                ->columnSpanFull()
                            ])
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
