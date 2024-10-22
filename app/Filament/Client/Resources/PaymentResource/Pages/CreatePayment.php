<?php

namespace App\Filament\Client\Resources\PaymentResource\Pages;

use App\Filament\Client\Resources\PaymentResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePayment extends CreateRecord
{
    protected static string $resource = PaymentResource::class;
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] =request()->user()?->client->id;
        return $data;
    }
}
