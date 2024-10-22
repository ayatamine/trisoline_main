<?php

namespace App\Filament\Client\Resources\QuotaResource\Pages;

use App\Models\File;
use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Client\Resources\QuotaResource;

class EditQuota extends EditRecord
{
    protected static string $resource = QuotaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
    public function mutateFormDataBeforeFill(array $data): array
    {
        $data['products'] = $this->record->products()->get();
       
        return $data;
    }
    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        try{
            $products =$data['products'];
            unset($data['products']);
            $record->update($data);

            DB::beginTransaction();
            if($products)
            {
                $record->products()->delete();
                foreach ($products as $p) {
                    $product = new Product;
                    $product->name = $p['name'];
                    $product->price = $p['expected_price'];
                    $product->expected_price = $p['expected_price'];
                    $product->quantity = $p['quantity'];
                    $product->description = $p['description'];
                    
                    if($p['images'] &&  count($p['images'])){
                        $product->thumbnail = $p['images'][0];
                        $product->save();
                        //save the last of images
                        foreach($p['images'] as $file)
                        {
                            $albumFile = new File();
                            $albumFile->fileable_id = $product->id;
                            $albumFile->fileable_type = Product::class;
                            $albumFile->type = 'image';
                            $albumFile->file = $file;
                            $albumFile->save();

                        }
                    }else{
                        $product->thumbnail = 'products/product.png';
                        $product->save();
                    }

                    $record->products()->save($product);
                   
                }
            }
            DB::commit();
            
        }
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
        return $record;
    }
}
