<?php

namespace App\Filament\Admin\Resources\QuotaResource\Pages;

use App\Models\Quota;
use Filament\Actions;
use App\Models\Message;
use App\Models\Discussion;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ViewRecord;
use Spatie\LivewireFilepond\WithFilePond;
use App\Filament\Admin\Resources\QuotaResource;

class ViewAdminQuota extends ViewRecord
{
    protected static string $resource = QuotaResource::class;
    use WithFilePond;
    protected static string $view = 'filament.resources.quota.pages.view-admin-quota';

    #[Validate('required|string|min:5')] 
    public $content = '';
 
    public $attachments = [];
 



    public function sendMessage()
    {
      try{
        
            DB::beginTransaction();

          
            $discussion = $this->record?->discussion;
            
            if(!$discussion)
            {
                $discussion = Discussion::create([
                    'discussable_id' =>$this->record->id,
                    'discussable_type' =>Quota::class,
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
            $message->receiver_id = $this->record?->user?->client_id;
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
    }

}
