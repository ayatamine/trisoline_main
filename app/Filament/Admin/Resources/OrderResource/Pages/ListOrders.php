<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use Filament\Tables\Actions\BulkActionGroup;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Resources\Pages\ListRecords;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use App\Filament\Admin\Resources\OrderResource;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            // BulkActionGroup::make([
            //     ExportBulkAction::make()->exports([
            //         ExcelExport::make()->withColumns([
            //             Column::make('name'),
            //             Column::make('client.user.name')->heading('Client Name'),
            //             Column::make('status'),
            //             Column::make('payment_status'),
            //             Column::make('expected_delivery_date'),
            //             Column::make('real_delivery_date'),
            //             Column::make('shippingAddress.fullAddress')->heading('Shipping Address'),
            //             Column::make('currency')->heading('Currency')
            //             ->formatStateUsing(fn ($state) => "$state->name ($state->symbol)"),
            //             Column::make('containers'),
            //             Column::make('inspected_at')
            //             ->formatStateUsing(fn ($state) => Carbon::createFromDate($state)),
            //             Column::make('approved_at')
            //             ->formatStateUsing(fn ($state) => Carbon::createFromDate($state)),
            //             Column::make('completed_at')
            //             ->formatStateUsing(fn ($state) => Carbon::createFromDate($state)),
                    
            //         ]),
            //     ]),
            // ])
           
        ];
    }
    
}
