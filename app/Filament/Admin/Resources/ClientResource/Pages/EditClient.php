<?php

namespace App\Filament\Admin\Resources\ClientResource\Pages;

use Filament\Actions;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\ClientResource;

class EditClient extends EditRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public  function mutateFormDataBeforeSave(array $data): array
    {
        try
        {
            $this->validate();
         
            DB::beginTransaction();
            if($data['password'] == null) unset($data['password']);
            $this->record->user->update($data);
       
            DB::commit();
            return ['user_id'=>$this->record->user->id];
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
        
    }
    public  function mutateFormDataBeforeFill(array $data): array
    {
        $data['name'] = $this->record->user->name;
        $data['email'] = $this->record->user->email;
        return $data;
        
    }
}
