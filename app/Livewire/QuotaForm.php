<?php

namespace App\Livewire;

use App\Models\File;
use App\Models\User;
use App\Models\Quota;
use App\Models\Client;
use App\Models\Product;
use Livewire\Component;
use Filament\Forms\Form;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Support\Enums\IconSize;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use App\Forms\Components\ContractCondition;
use Filament\Forms\Components\Actions\Action;
use App\Notifications\SendRegistrationPassword;
use Filament\Forms\Concerns\InteractsWithForms;

class QuotaForm extends Component implements HasForms
{
    use InteractsWithForms;
    public Quota $order;
    public $register_account=false;
    public $is_success=false;
    public $accept_contact=false;
    public ?array $data = [];
    public function mount()
    {}
    public function render()
    {
        return view('livewire.quota-form')->extends('components.layouts.client')->section('body');
    }
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make(trans('dash.quota_info'))
                ->label(trans('dash.quota_info'))
                ->schema([
                TextInput::make('business_name')
                    ->label(trans('dash.business_name'))
                    ->required(),
                TextInput::make('legal_representative_name')
                    ->label(trans('dash.legal_representative_name'))
                    ->required(),
                Select::make('country')->label(trans('dash.country'))
                    ->required()
                    // ->searchable()
                    ->options(function () {
                        $response = Http::get('https://restcountries.com/v3.1/all');
                        $jsonData = $response->json();
                    
                        foreach($jsonData as $c)
                        {
                            $countries[$c['flag']] = $c['name']['common'];
                        }
                        return $countries;
            
                    }),
                TextInput::make('full_address')
                    ->label(trans('dash.full_address'))
                    ->required(),
                TextInput::make('email')
                    ->label(trans('dash.email'))
                    ->email()
                    ->required(),
                TextInput::make('phone_number')
                    ->label(trans('dash.phone_number'))
                    ->tel()
                    ->maxLength(14)
                    ->required(),
                TextInput::make('commercial_register_number')
                    ->label(trans('dash.commercial_register_number')),
                TextInput::make('tax_number')
                    ->label(trans('dash.tax_number')),
                Grid::make()
                    ->columns([
                        'default' => 'full',
                        'md' => 3,
                        'lg' => 3,
                        'xl' => 3,
                    ])
                    ->schema([
                        TextInput::make('available_budget')
                        ->numeric()
                        ->columnSpan([
                            'default' => 'full',
                            'md' => 2,
                            'lg' => 2,
                            'xl' => 2,
                        ])
                        ->label(trans('dash.available_budget')),
                        Select::make('currency')->label(trans('dash.currency'))
                        ->columnSpan([
                            'default' => 'full',
                            'md' => 1,
                            'lg' => 1,
                            'xl' => 1,
                        ])
                        // ->searchable()
                        ->options(['USD'=>'USD','EUR'=>'EUR','SAR'=>'SAR','CNY'=>'CNY']),
                    ]),

                Select::make('service_type')
                    ->label(trans('dash.service_type'))
                    ->options([
                        'trade'=>trans('dash.trade'),
                        'real_estate'=>trans('dash.real_estate')
                    ])
                    ->default('trade')
                    ->required(),
                Checkbox::make('is_customs_clearance_available'),
                
                // Select::make(name: 'currency_id')
                //     ->label(trans('dash.currency'))
                //     ->options([])
                //     ->preload()
                //     ->required(),
                // ]),
                Section::make('quotaProducts')
                ->label(trans('dash.products'))
                ->schema([
                    
                        Repeater::make('products')
                         ->required()
                         ->schema([
                            Grid::make('')
                            ->columns(4)
                            ->schema([
                            TextInput::make('name')
                                ->label(trans('dash.name'))
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 2,
                                    // '2xl' => 1,
                                ])
                                ->required(),
                            TextInput::make('expected_price')
                                ->label(trans('dash.expected_price'))
                                ->numeric()
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 1,
                                ])
                                ->required(),
                            TextInput::make('quantity')
                                ->label(trans('dash.qte'))
                                ->numeric()
                                ->columnSpan([
                                    'default' => 'full',
                                    'sm' => 1,
                                ])
                                ->required(),
                            
                            FileUpload::make(name: 'images')
                                ->label(trans('dash.image'))
                                ->image()
                                ->multiple()
                                ->directory('products')
                                ->columnSpanFull()
                            ]),
                            Textarea::make('description')
                                ->label(trans('dash.note'))
                                ->columnSpanFull(), 
                        ])
                        ->minItems(1)
                        ->defaultItems(1)
                        ->cloneable(),
                        Repeater::make('containers')
                        ->required()
                        ->label(trans('dash.containers_count'))
                        ->columnSpanFull()
                        ->required()
                        ->schema(components: [
                            Grid::make('')
                                ->columns(2)
                                ->schema([
                                    Select::make('type')
                                    ->label(trans('dash.container_type'))
                                    ->options(
                                        ['big_container'=>trans('dash.big_container'),'medium_container'=>trans('dash.medium_container'),'small_container'=>trans('dash.small_container')]
                                    )
                                    ->required(),
                                    TextInput::make('count')
                                        ->label(trans('dash.containers_count'))
                                        ->numeric()
                                        ->required(),
                                ])
                        ]),    
                ]),

                // ViewField::make('accept_contract')
                //     ->required()
                //     ->view('forms.components.contract-condition')
                Checkbox::make('terms')
                ->label(fn() => trans('dash.accept_contract_title'))
                ->hintAction(
                    Action::make(trans('dash.accept_contract_title'))
                        ->hiddenLabel(false)
                        ->icon('heroicon-o-information-circle')
                        ->iconSize(IconSize::Large)
                        ->tooltip(trans('dash.accept_contract_title'))
                        ->url(route('quotation_terms'))
                        ->openUrlInNewTab()
                )
                ->required()
                ])
            ])
            ->statePath('data');
    }
    public function create()
    {
       

        try{
            DB::beginTransaction(); 
            $data = $this->data;
            $this->validate();
            $client=null; $quota = null;
            if($this->register_account)
            {
                $password  = Str::random(8);
                $user  = User::create([
                    'name'=>$data['business_name'],
                    'email'=>$data['email'],
                    'password'=>$password
                ]);
                $client = Client::create([ 'user_id'=>$user->id]);
       
                $user->notify( new SendRegistrationPassword($user->email,$password));


                $products =$data['products'] ?? [];
                $data['containers'] = array_values($data['containers']) ?? [];
                unset($data['products']);
                $data['client_id'] = $client->id;
                $quota = Quota::create($data);
                if(count($products))
                {
                    $this->attachProducts($quota,$products);
                }
            }else{
                $products =$data['products'] ??  [];
                unset($data['products']);
                $data['containers'] = array_values($data['containers']) ?? [];
                $quota = Quota::create($data);
            }
           
            

             
            DB::commit();
             $this->form->fill();
             $this->is_success =true;
            Notification::make() 
            ->title(trans('dash.creation_success',['model'=>trans_choice('dash.quota',1)]))
            ->success()
            ->send();
            
        } 
        catch(\Exception $ex)
        {
            DB::rollBack();
            throw $ex;
        }
    }
    public function attachProducts(Quota $quota,array $products)
    {
        foreach($products as $product)
                    {
                      
                        $new_product = new Product;
                        $new_product->name = $product['name'];
                        $new_product->expected_price = $product['expected_price'];
                        $new_product->price = 0;
                        $new_product->quantity = $product['quantity'];
                        $new_product->description = $product['description'];
                        if($product['images'] &&  count($product['images'])){
                            $new_product->thumbnail = $product['images'][0] ?? "product.png";
                            $new_product->save();
                            //save the last of images
                            foreach($product['images'] as $file)
                            {
                                $albumFile = new File();
                                $albumFile->fileable_id = $new_product->id;
                                $albumFile->fileable_type = Product::class;
                                $albumFile->type = 'image';
                                $albumFile->file = $file;
                                $albumFile->save();

                            }
                        }else{
                            $new_product->thumbnail = 'products/product.png';
                            $new_product->save();
                        }
                        
                       
    
                        $quota->products()->save($new_product);
                    }
    }

    public function createWithAccount()
    {
        $this->register_account =true;
        return $this->create();
    }
}
