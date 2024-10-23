<?php

namespace App\Filament\Client\Resources\QuotaResource\Pages;

use App\Models\Quota;
use Filament\Actions;
use App\Models\Message;
use App\Models\Discussion;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\DB;
use Filament\Resources\Pages\ViewRecord;
use Livewire\WithFileUploads;
use Spatie\LivewireFilepond\WithFilePond;
use App\Filament\Client\Resources\QuotaResource;

class ViewQuota extends ViewRecord
{
    use WithFilePond;

    protected static string $resource = QuotaResource::class;
    protected static string $view = 'filament.resources.quota.pages.view-quota';

    #[Validate('required|string|min:5')] 
    public $content = '';
 
    public $attachments = [];
 



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
