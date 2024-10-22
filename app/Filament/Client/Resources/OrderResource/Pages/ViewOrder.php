<?php

namespace App\Filament\Client\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Client\Resources\OrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->hidden(fn(Order $order)=>$order->status !="pending"),
        ];
    }
    
    public function mutateFormDataBeforeFill(array $data): array
    {

        $data['products_info'] = $this->record->products;
        return $data;
    }
}
