<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Models\File;
use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Admin\Resources\OrderResource;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    // public function mutateFormDataBeforeCreate(array $data): array
    // {
    //     return $data;
    // }
    protected function handleRecordCreation(array $data): Model
    {
      
        try{
            DB::beginTransaction();
            $result = static::getModel()::create($data);
  
            
            if($data['products_info'])
            {
                
                foreach ($data['products_info'] as $p) {
                    $product = new Product;
                    $product->name = $p['name'];
                    $product->price = $p['price'];
                    $product->expected_price = $p['price'];
                    $product->quantity = $p['quantity'];
                    $product->description = $p['description'];
                   
                    if($p['images'] &&  count($p['images'])){
                        $product->thumbnail = $p['images'][0];
                        $product->save();
                        //save the last of images
                        foreach($p['images'] as $file)
                        {
                            $albumFile = new File();
                            $albumFile->fileable_id = $p->id;
                            $albumFile->fileable_type = Product::class;
                            $albumFile->type = 'image';
                            $albumFile->file = $file;
                            $albumFile->save();

                        }
                    }else{
                        $product->thumbnail = 'products/product.png';
                        $product->save();
                    }
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
