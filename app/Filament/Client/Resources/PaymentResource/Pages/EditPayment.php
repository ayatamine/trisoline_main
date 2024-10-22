<?php

namespace App\Filament\Client\Resources\PaymentResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\Cache;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Client\Resources\PaymentResource;

class EditPayment extends EditRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    public function mutateFormDataBeforeSave(array $data): array
    {
        $lockKey = 'payment_edit_' . $this->record->id;
        
        try {
            $lock = Cache::lock($lockKey, 10);
            if ($lock->get()) {
                return $data;
              } else {
               $this->halt();
            }
          } finally {
             $lock->release();
          }
        
      
        return $data;
    }
}
