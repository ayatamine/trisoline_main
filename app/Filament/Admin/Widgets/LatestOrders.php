<?php

namespace App\Filament\Admin\Widgets;

use Filament\Tables;
use App\Models\Order;
use Filament\Tables\Table;
use App\Filament\Admin\Resources\OrderResource;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Filters\SelectFilter;

class LatestOrders extends BaseWidget
{
    protected static ?int $sort = 7;

    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery())
            ->defaultPaginationPageOption(5)
            ->defaultSort('created_at', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make(name: 'id')
                    ->label(trans('dash.number'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('client.user.email')
                    ->label(trans('dash.email'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('expected_delivery_date')
                ->label(trans('dash.expected_delivery_date'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shippingAddress.full_address')
                    ->label(trans('dash.address'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label(trans('dash.status'))
                    ->colors([
                        'danger' => 'refuned',
                        'warning' => 'pending',
                        'info' => 'approved',
                        'success' => fn ($state) => in_array($state, [ 'inspected','completed']),
                    ]),
                Tables\Columns\TextColumn::make('currency.name')
                    ->label(trans('dash.currency'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(trans('dash.created_at'))
                    ->date()
                    ->searchable()
                    ->sortable(),
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
                Tables\Actions\Action::make('open')
                    ->url(fn (Order $record): string => OrderResource::getUrl('edit', ['record' => $record])),
            ]);
    }
}
