<?php

namespace App\Filament\Admin\Resources\ClientResource\Pages;

use App\Models\User;
use Filament\Actions;
use App\Models\Client;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\ClientResource;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;
    public  function mutateFormDataBeforeCreate(array $data): array
    {
        try
        {
            DB::beginTransaction();
            $user = User::create($data);
       
            DB::commit();
            return ['user_id'=>$user->id];
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
        
    }
}
