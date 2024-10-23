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
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\OrderResource\Pages;
use App\Filament\Admin\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

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
            Forms\Components\TextInput::make('containers_count')
            ->label(trans('dash.containers_count'))
            ->numeric()
            ->columnSpanFull()
            ->required(),  
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
            'view' => Pages\EditOrder::route('/{record}'),
        ];
    }
}
