<?php

namespace App\Filament\Client\Resources\PaymentResource\Pages;

use Filament\Actions;
use App\Models\Payment;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Client\Resources\PaymentResource;

class ViewPayment extends ViewRecord
{
    protected static string $resource = PaymentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->visible(fn(Payment $payment)=>$payment->status == "pending"),
        ];
    }
}
