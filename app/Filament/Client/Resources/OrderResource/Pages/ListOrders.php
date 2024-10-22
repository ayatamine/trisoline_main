<?php

namespace App\Filament\Client\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Actions;
use Illuminate\Support\Str;
use Filament\Actions\Action;
use App\Models\ShippingAddress;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Client\Resources\OrderResource;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
    // protected static string $view = 'livewire.client.orders.index';
    // public $search = '';
    // public $status_filters = ['pending','approved','inspected','completed','refunded'];
    // public $statuses = [];
    // public $shipping_address = [];
    // public function render():View
    // {
    //     sleep(1);
     
    //     $orders = request()->user()?->client->orders()
    //             ->when(Str::length($this->search) > 0, function(Builder $query) 
    //             {
    //                return $query->where('name', 'like', '%'. $this->search .'%')
    //                ->orwhere('id', 'like', '%'. $this->search .'%');
    //             })
    //             ->when($this->statuses, function(Builder $query) 
    //             {
    //                return $query->whereIn('status',$this->statuses);
    //             })
    //             // ->where('client_id',request()->user()?->client?->id) 
    //             ->with('shippingAddress')->with('currency:id,symbol')->with('vendor:id')
    //             ->filter()->sort()->paginate(2);
          
    //     return view('livewire.client.orders.index',compact('orders'))->layout('layouts.dashboard');
    // }
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    public function updateShippingAddress(): Action
    {
        return Action::make('updateShippingAddress')
                ->icon('heroicon-m-edit')
                ->color(color: 'gray')
                ->form([
                    
                    Select::make(name: 'shipping_address_id')
                    ->label(trans('dash.shipping_address'))
                    ->options(ShippingAddress::whereClientId(auth()->user()->client?->id)->pluck('full_address','id'))
                    ->preload()
                    ->createOptionForm([
                        TextInput::make('first_name')->label(trans('dash.first_name'))
                            ->required(),
                        TextInput::make('last_name')->label(trans('dash.last_name'))
                            ->required(),
                        TextInput::make('phone_number')->label(trans('dash.phone_number'))
                            ->hint('ex:+00155555555')
                            ->required()->tel()->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/'),
                        Select::make('country')->label(trans('dash.country'))
                            ->searchable()
                            ->options(function () {
                                $response = Http::get('https://restcountries.com/v3.1/all');
                                $jsonData = $response->json();
                            
                                foreach($jsonData as $c)
                                {
                                    $countries[$c['flag']] = $c['name']['common'];
                                }
                                return $countries;
                    
                            }),
                        TextInput::make('zip_code')->label(trans('dash.zip_code'))->numeric()->length(5)
                            ->required(),
                    ])
                    ->createOptionUsing(function (array $data) {
                        auth()->user()->client->shippingAddresses()->create($data)->getKey();
                        Notification::make()
                                    ->title(trans('dash.creation_success',['model'=>trans('dash.shipping_address')]))
                                    ->success()
                                    ->send();
                        
                    })
                    ->required(),
               ])
               ->action(function (array $arguments,array $data) {
                   Order::findOrFail($arguments['id'])->update(['shipping_address_id'=>$data['shipping_address_id']]);
                   Notification::make()
                   ->title(trans('dash.shipping_address_updated_successfully'))
                   ->icon('heroicon-o-document-text')
                   ->iconColor('success')
                   ->send();
                   return redirect(request()->header('Referer'));
                   // dd($fee);
                   // DB::update('update student_fee set name = ? where id = ?',[$name,$arguments['fee_id']]);
                   
               });
    }
}
