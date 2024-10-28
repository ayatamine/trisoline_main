<?php

namespace App\Filament\Client\Resources\ComplaintResource\Pages;

use App\Filament\Client\Resources\ComplaintResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateComplaint extends CreateRecord
{
    protected static string $resource = ComplaintResource::class;
    public function mutateFormDataBeforeCreate(array $data): array
    {
        if($data['reason2'])
        {
            $data['reason'] =$data['reason2'];
        }
        // if(array_key_exists('documents',$data))
        // {
        //         $payment->update(['documents' => json_encode($this->saveFiles($data['documents'],'payments_documents',$payment->id,Payment::class, 'document',true))]);
        // }
        
        return $data;
    }
}
