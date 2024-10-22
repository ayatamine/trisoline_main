<?php

namespace App\Filament\Client\Resources\OrderResource\Pages;

use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Client\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    public function mutateFormDataBeforeFill(array $data): array
    {

        $data['products_info'] = $this->record->products;
        return $data;
    }


    protected function handleRecordUpdate(Model $record, array $data): Model
    {
      
        try{

            DB::beginTransaction();
            if($data['products_info'])
            {
                
                $record->products()->delete();
                foreach ($data['products_info'] as $p) {
                    $product = new Product;
                    $product->name = $p['name'];
                    $product->price = $p['price'];
                    $product->expected_price = $p['price'];
                    $product->quantity = $p['quantity'];
                    $product->description = $p['description'];
                    $product->thumbnail = $p['thumbnail'];
                    $product->save();

                    $record->products()->save($product);
                   
                }
            }
            DB::commit();
            
            $record->update($data);
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
        return $record;
    }
}
