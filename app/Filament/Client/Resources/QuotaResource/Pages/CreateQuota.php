<?php

namespace App\Filament\Client\Resources\QuotaResource\Pages;

use App\Models\File;
use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Client\Resources\QuotaResource;

class CreateQuota extends CreateRecord
{
    protected static string $resource = QuotaResource::class;
    public function mutateFormDataBeforeCreate(array $data): array
    {
        $data['email'] =auth()->user()->email;
        $data['legal_representative_name'] =auth()->user()->name;
        
        return $data;
    }
    protected function handleRecordCreation(array $data): Model
    {
      
        try{
            $products =$data['products'];
            unset($data['products']);
            $result = static::getModel()::create($data);

            DB::beginTransaction();
            if($products)
            {
                
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
                    $result->products()->save($product);
                   
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
