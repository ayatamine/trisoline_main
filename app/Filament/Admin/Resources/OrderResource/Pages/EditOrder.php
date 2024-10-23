<?php

namespace App\Filament\Admin\Resources\OrderResource\Pages;

use App\Models\File;
use Filament\Actions;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Admin\Resources\OrderResource;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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
                    // $product->thumbnail = $p['thumbnail'];
                    if($p['images'] &&  count($p['images'])){
                        $product->thumbnail = $p['images'][0];
                        $product->save();
                        //save the last of images
                        foreach($p['images'] as $file)
                        {
                            $albumFile = new File();
                            $albumFile->fileable_id = $product['id'];
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
