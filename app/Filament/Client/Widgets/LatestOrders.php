<?php

namespace App\Filament\Client\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\View;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Filters\SelectFilter;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestOrders extends BaseWidget
{
    protected static string $chartId = 'QuotaChart';
    protected static ?int $sort = 7;
    protected static ?string $maxHeight = '350px';
    public function getColumnSpan(): int | string | array
    {
        return 2;
    }
    public function table(Table $table): Table
    {
        return $table
        ->query(Order::query()->whereClientId(request()->user()?->client->id))
        ->contentGrid([
            'md' => 1,
            'xl' => 1,
        ])
        ->columns([
            // 'name',
            // 'vendor_id',
            // 'client_id',
            // 'status',
            // 'payment_status',
            // 'expected_delivery_date',
            // 'real_delivery_date',
            // 'shipping_address_id',
            // 'currency_id',
            // 'vendor_info',
            // 'containers',
            // 'approved_at',
            // 'inspected_at',
            // 'completed_at',
            // 'refuned_at',
                TextColumn::make('name')->label(trans('dash.name'))->searchable(),
                TextColumn::make('expected_delivery_date')->label(trans('dash.expected_delivery_date'))->date()->sortable(),
                TextColumn::make('real_delivery_date')->label(trans('dash.real_delivery_date'))->date()->sortable(),
                TextColumn::make('shippingAddress.fullAddress')->label(trans('dash.shipping_address'))->limit(50)->sortable(),
                TextColumn::make('currency_id')->label(trans('dash.currency'))->searchable()->sortable(),
                TextColumn::make('approved_at')->label(trans('dash.approved_at'))->searchable()->sortable(),
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
}
