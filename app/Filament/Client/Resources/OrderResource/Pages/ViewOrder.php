<?php

namespace App\Filament\Client\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use App\Models\Message;
use App\Models\Discussion;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ViewRecord;
use App\Filament\Client\Resources\OrderResource;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    #[Validate('required|string|min:5')] 
    public $content = '';
 
    public $attachments = [];
    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make()->hidden(fn(Order $order)=>$order->status !="pending"),
        ];
    }
    
    public function mutateFormDataBeforeFill(array $data): array
    {

        $data['products_info'] = $this->record->products;
        return $data;
    }
    public function sendMessage()
    {
      try{
            $this->validate([ 
                'content' => 'required|min:3',
                'attachments' => 'sometimes|nullable',
                'attachments.*' => 'max:2048',
            ]);
            DB::beginTransaction();

          
            $discussion = $this->record?->discussion;
            
            if(!$discussion)
            {
                $discussion = Discussion::create([
                    'discussable_id' =>$this->record->id,
                    'discussable_type' =>Order::class,
                ]);
            }
            $attachments_names=[];
            if($this->attachments)
            {
                
                foreach ($this->attachments as $attachment) {
                
                    array_push($attachments_names,$attachment->store( 'discussions','public'));
                }
            }
            $message = new Message;
            $message->discussion_id = $discussion->id;
            $message->sender_id = auth()->user()->id;
            $message->content = $this->content;
            $message->attachments = $attachments_names;
            $message->save();

            DB::commit();
            $this->reset(['content', 'attachments']);
      }
      catch(\Exception $ex)
      {
            DB::rollBack();
            throw $ex;
      }

        // 'discussion_id',
        // 'content',
        // 'attachment',
        // $this->validate();
        // dd($thi);
    }
}
