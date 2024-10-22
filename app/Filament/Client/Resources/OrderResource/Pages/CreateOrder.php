<?php

namespace App\Filament\Client\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Client\Resources\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['client_id'] =auth()->user()?->client?->id;
        return $data;
    }
    protected function handleRecordCreation(array $data): Model
    {
      
        try{
            $result = static::getModel()::create($data);
        
            DB::beginTransaction();
            if($data['products_info'])
            {
                
                foreach ($data['products_info'] as $p) {
                    $product = new Product;
                    $product->name = $p['name'];
                    $product->price = $p['price'];
                    $product->expected_price = $p['price'];
                    $product->quantity = $p['quantity'];
                    $product->description = $p['description'];
                    $product->thumbnail = $p['thumbnail'];
                    $product->save();

                   
                }
            }
            DB::commit();
            
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
        return $result;
    }
}
