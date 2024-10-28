<?php

namespace App\Filament\Client\Resources\ComplaintResource\Pages;

use App\Filament\Client\Resources\ComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditComplaint extends EditRecord
{
    protected static string $resource = ComplaintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
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
    public function mutateFormDataBeforeSave(array $data): array
    {
        if($data['reason2'])
        {
            $data['reason'] =$data['reason2'];
        }
        
        return $data;
    }
}
