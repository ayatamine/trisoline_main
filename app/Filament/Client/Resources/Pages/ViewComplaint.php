<?php

namespace App\Filament\Client\Resources\ComplaintResource\Pages;

use App\Filament\Client\Resources\ComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewComplaint extends ViewRecord
{
    protected static string $resource = ComplaintResource::class;
    protected static string $view ='livewire.complaint-details' ;
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
    public function mutateFormDataBeforeFill(array $data): array
    {
        // if($data['reason2'])
        // {
            $data['reason2'] =$data['reason'];
            
            $data['type'] = 'other';

            if($data['order_id']) $data['type'] = 'order';
            if($data['payment_id']) $data['type'] = 'payment';

        
        return $data;
    }
}
