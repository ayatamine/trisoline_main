<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Order;
use App\Models\Client;
use App\Models\Currency;
use Filament\Forms\Form;
use App\Models\Discussion;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\OrderResource\Pages;
use Filament\Infolists\Components\TextEntry\TextEntrySize;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;
    protected static ?int $sort = 6;

    protected static ?string $navigationIcon = 'icon-orders';
    public  static function getNavigationGroup():string
    {
            return trans('dash.clients_area');
    }

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
            Forms\Components\Select::make( 'client_id')
                ->label(trans('dash.client'))
                ->relationship(
                    name: 'client',
                )
                ->getOptionLabelFromRecordUsing(fn (Client $record) => "{$record->user->name}")
                ->preload()
                ->searchable()
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
                        Select::make('type')
                        ->label(trans('dash.container_type'))
                        ->options(
                            ['big_container'=>trans('dash.big_container'),'medium_container'=>trans('dash.medium_container'),'small_container'=>trans('dash.small_container')]
                        )
                        ->required(),
                        TextInput::make('count')
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
            ->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->columns([
                // Stack::make([
                //     TextColumn::make('name')->label(trans('dash.name'))->searchable(),
                //     TextColumn::make('created_at')->label(trans('dash.order_date'))->searchable()->sortable(),
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
                // ]),
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
                Tables\Actions\Action::make('updateStatus')
                ->label(trans('dash.updateStatus'))
                ->form([
                    Select::make('status')
                            ->label(trans('dash.status'))
                            ->options([
                                'approved' => trans('dash.approved'),
                                'inspected' => trans('dash.inspected'),
                                'completed' => trans('dash.completed'),
                                'refunded' => trans('dash.refunded'),
                            ])
                ])
                ->action(function (array $data,Order $record): void {
                    if($data['status'] == "approved") 
                    {
                        if(!$record->discussion) Discussion::create(['discussable_type'=>Order::class,'discussable_id'=>$record->id,'is_open'=>1]);
                        $data['refunded_at'] = null;
                        $data['completed_at'] = null;
                        $data['approved_at'] = now();
                    }
                    if($data['status'] == "inspected") {
                        $data['completed_at'] = null;
                        $data['inspected_at'] = now();
                    }
                    if($data['status'] == "refunded") {
                        $data['completed_at'] = null;
                        $data['refunded_at'] = now();
                    }
                    $record->update($data);
                    Notification::make()
                    ->title(trans('dash.status_updated_successfully'))
                    ->icon('heroicon-o-document-text')
                    ->iconColor('success')
                    ->send();
                }),
                // Tables\Actions\EditAction::make()->hidden(fn(Order $order)=>$order->status !="pending"),
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
                                TextEntry::make('containers_count')->label(trans('dash.containers_count'))
                                ->color('success')
                                ->size(TextEntrySize::Large)
                                ->weight(FontWeight::Bold),
                                TextEntry::make('currency.name')->label(trans('dash.currency'))->weight(FontWeight::Bold),
                                
                                TextEntry::make('status')->label(trans('dash.status'))->weight(FontWeight::Bold)
                                ->color('success')
                                ->size(TextEntrySize::Large),
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
            'edit' => Pages\EditOrder::route('/{record}/edit'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
