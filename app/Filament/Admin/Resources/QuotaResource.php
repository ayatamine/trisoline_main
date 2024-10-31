<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Quota;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\Filter;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Support\Enums\FontWeight;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ViewField;
use Filament\Notifications\Notification;
use pxlrbt\FilamentExcel\Columns\Column;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Actions\Concerns\HasInfolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ViewEntry;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Filament\Infolists\Components\KeyValueEntry;
use Filament\Infolists\Components\Actions\Action;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\QuotaResource\Pages;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use App\Filament\Admin\Resources\QuotaResource\RelationManagers;

class QuotaResource extends Resource
{
    use HasInfolist;
    protected static ?string $model = Quota::class;

    protected static ?string $navigationIcon = 'icon-quotations';
    public static  function getNavigationGroup():string
    {
            return trans('dash.clients_area');
    }
    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Section::make(trans('dash.quota_info'))
            ->label(trans('dash.quota_info'))
            ->schema([
            TextInput::make('business_name')
                ->label(trans('dash.business_name'))
                ->required(),
            // TextInput::make('legal_representative_name')
            //     ->label(trans('dash.legal_representative_name'))
            //     ->required(),
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
            // TextInput::make('email')
            //     ->label(trans('dash.email'))
            //     ->email()
            //     ->required(),
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
                ->columns(3)
                ->schema([
                    TextInput::make('available_budget')
                    ->numeric()
                    ->columnSpan(2)
                    ->label(trans('dash.available_budget')),
                    Select::make('currency')->label(trans('dash.currency'))
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
                            ->columnSpan(2)
                            ->required(),
                        TextInput::make('expected_price')
                            ->label(trans('dash.expected_price'))
                            ->numeric()
                            ->columnSpan(1)
                            ->required(),
                        TextInput::make('quantity')
                            ->label(trans('dash.qte'))
                            ->numeric()
                            ->columnSpan(1)
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
                    
            ]),
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
            // ViewField::make('accept_contact')
            //     ->required()
            //     ->view('forms.components.contract-condition')
        ])
        ]);
    }

    public static function table(Table $table): Table
    {
     
        return $table
            ->columns([
                TextColumn::make('client_id')->label(trans('dash.type'))
                    ->formatStateUsing(fn(Quota $quota):string => $quota->client_id!=0  ? trans("dash.client") : trans('dash.guest'))
                    ->sortable(),
                TextColumn::make('id')->label(trans_choice('dash.id',1))
                ->formatStateUsing(fn(string $state)=>"#$state")
                ->searchable()->sortable(),
                TextColumn::make('business_name')->label(trans_choice('dash.name',1))->sortable()->searchable(),
                TextColumn::make('legal_representative_name')->label(trans_choice('dash.legal_representative_name',1))->sortable()->searchable(),
                TextColumn::make('country')->label(trans('dash.country'))->searchable()->sortable()->searchable(),
                TextColumn::make('full_address')->label(trans('dash.address'))->searchable()->limit(50)->sortable()->searchable(),
                TextColumn::make('available_budget')->label(trans('dash.available_budget'))->searchable()->limit(50)->sortable(),
                TextColumn::make('currency')->label(trans('dash.currency'))->searchable()->limit(50)->sortable(),
                TextColumn::make('service_type')->label(trans('dash.service_type'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                            'trade' => 'primary',
                                            'real_estate' => 'warning',
                            })
                            ->formatStateUsing(fn(string $state)=> trans("dash.$state")),
                TextColumn::make('status')->label(trans('dash.status'))
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                            'processing' => 'primary',
                                            'pending' => 'warning',
                                            'processed' => 'success',
                                            'rejected' => 'danger',
                            })
                            ->formatStateUsing(fn(string $state)=> trans("dash.$state")),
                TextColumn::make('created_at')->label(trans('dash.created_at'))->date()->sortable(),
            ])
            ->filters([
                Filter::make('type')
                    ->label(trans('dash.type'))
                    ->form([
                        Select::make('type')->label(trans('dash.type'))
                        ->options([
                            'guest' => trans('dash.guest'),
                            'client' => trans('dash.client')
                        ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['type'] == "guest",
                                fn (Builder $query, $d): Builder => $query->whereNull('client_id')
                            )
                            ->when(
                                $data['type'] =="client",
                                fn (Builder $query, $to): Builder => $query->whereNotNull('client_id')
                            );
                    }),
                SelectFilter::make('status')->label(trans('dash.status'))->options([
                    'pending' => trans('dash.pending'),
                    'processing' => trans('dash.processing'),
                    'processed' => trans('dash.processed'),
                    'rejected' => trans('dash.rejected')
                ]),
                 
                Filter::make('available_budget')
                    ->form([
                        TextInput::make('from')->label(trans('dash.budget_from'))->numeric(),
                        TextInput::make('to')->label(trans('dash.budget_to'))->numeric(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['from'],
                                fn (Builder $query, $from): Builder => $query->whereBetween('available_budget', [$from,100000000000000]),
                            )
                            ->when(
                                $data['to'],
                                fn (Builder $query, $to): Builder => $query->whereBetween('available_budget', [0, $to]),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('updateStatus')
                ->label(trans('dash.updateStatus'))
                ->form([
                    Select::make('status')
                            ->label(trans('dash.status'))
                            ->options([
                                'processing'=>'processing',
                                'processed'=>'processed',
                                'rejected'=>'rejected',
                            ])
                ])
                ->action(function (array $data,Quota $record): void {
                    if($data['status'] == "processing") 
                    {
                        if(!$record->discussion && ($record->client_id !== 0)) $record->discussion()->create(['discussable_type'=>Quota::class,'discussable_id'=>$record->id,'is_open'=>1]);
                        $data['rejected_at'] = null;
                        $data['processed_at'] = null;
                        $data['processing_at'] = now();
                    }
                    if($data['status'] == "processed") $data['processed_at'] = now();
                    if($data['status'] == "rejected") {
                        $data['processing_at'] = null;
                        $data['processed_at'] = null;
                        $data['rejected_at'] = now();
                    }
                    $record->update($data);
                    Notification::make()
                    ->title(trans('dash.status_updated_successfully'))
                    ->icon('heroicon-o-document-text')
                    ->iconColor('success')
                    ->send();
                }),
                // Tables\Actions\EditAction::make()->visible(fn(Quota $quota) =>$quota->status == 'pending'),
            ])
            ->bulkActions([
                ExportBulkAction::make()->exports([
                    ExcelExport::make()->withColumns([
                        Column::make('business_name'),
                        Column::make('legal_representative_name'),
                        Column::make('country'),
                        Column::make('full_address'),
                        Column::make('phone_number'),
                        Column::make('email'),
                        Column::make('commercial_register_number'),
                        Column::make('tax_number'),
                        Column::make('available_budget'),
                        Column::make('currency'),
                        Column::make('available_budget'),
                        Column::make('service_type'),
                        Column::make('status'),
                        Column::make('client.user.name')->heading('Client Name'),

                        Column::make('processing_at'),
                        Column::make('processed_at'),
                        Column::make('expected_delivery_date'),
                        Column::make('real_delivery_date'),
                        Column::make('containers')->formatStateUsing(function ($state) {
                            $concat=[];
                           foreach($state as $k=>$co)
                           {
                                array_push($concat,"$k : $co");
                           }
                           return $concat;
                        }),
                    
                    ])->askForFilename(),

                ]),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                    \Filament\Infolists\Components\Section::make(trans('dash.quota_info'))
                        ->headerActions([
                            // Action::make(trans('dash.edit'))
                            //     ->url(fn (Student $record): string => route('filament.admin.resources.students.edit', $record))
                        ])
                        ->columns(2)
                        ->id('main-section')
                        ->schema([

                                TextEntry::make('service_type')->label(trans('dash.service_type'))
                                // ->formatStateUsing(callback: fn (string $state) => $state." ".trans("dash.$state"))
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'trade' => 'primary',
                                    'real_estate' => 'warning',
                    })
                                ->weight(FontWeight::Bold),
                                TextEntry::make('business_name')->label(trans('dash.business_name'))->weight(FontWeight::Bold),
                                TextEntry::make('legal_representative_name')->label(trans('dash.legal_representative_name'))->weight(FontWeight::Bold),
                                TextEntry::make('country')->label(trans('dash.country'))->weight(FontWeight::Bold),
                                TextEntry::make( 'full_address')->label(trans('dash.address'))->weight(FontWeight::Bold),
                                TextEntry::make( 'phone_number')->label(trans('dash.phone_number'))->weight(FontWeight::Bold)
                                ->badge()
                                ->color('info')
                                ->copyable()
                                ->copyMessage('Copied!')
                                ->icon('heroicon-m-phone')
                                ->copyMessageDuration(1500),
                                TextEntry::make( 'email')->label(trans('dash.email'))->weight(FontWeight::Bold)
                                ->icon('heroicon-m-envelope')
                                ->badge()
                                ->color('info')
                                ->copyable()
                                ->copyMessage('Copied!')
                                ->copyMessageDuration(1500),
                                
                                TextEntry::make('available_budget')->label(trans('dash.available_budget'))
                                ->formatStateUsing(callback: fn (Quota $quota) => $quota->available_budget." ".$quota->currency)
                                ->weight(FontWeight::Bold),
                                ViewEntry::make('containers')->label(trans('dash.containers_count'))->view('infolists.components.containers-count'),
                                TextEntry::make('created_at')->label(trans('dash.created_at'))->date()->weight(FontWeight::Bold),

                                TextEntry::make('rejection_note')->label(trans('dash.rejection_note'))
                                ->hidden(fn (Quota $quota) => $quota->rejection_note == null)
                                ->weight(FontWeight::Bold),
                        ]),
                    \Filament\Infolists\Components\Section::make(trans('dash.products_info'))
                        ->id('products_info-section')
                        ->schema([
                                
                                ViewEntry::make('products')->label(trans('dash.products_info'))->view('infolists.components.view-product'),
                    
                        ]),
                    \Filament\Infolists\Components\Section::make(trans('dash.status'))
                            ->id('status-section')
                            ->schema([
                                    
                                    ViewEntry::make('status')->label(trans('dash.quota_status'))->view('infolists.components.view-quota-status'),
                        
                            ]),
                  
                    \Filament\Infolists\Components\Section::make(trans('dash.quota_discussion'))
                            ->id('discussion-section')
                            ->schema([
                                    
                                    ViewEntry::make('discussion')->label(trans('dash.quota_discussion'))->view('infolists.components.view-quota-discussion')
                                    ->registerActions([
                                        Action::make('closeDiscussion')
                                            ->label(trans('dash.close_discussion'))
                                            ->requiresConfirmation()
                                            ->action(function (Quota $record) {
                                                $record->discussion->update(['is_open'=>false]);
                                                Notification::make()
                                                ->title(trans('dash.discussion_closed_successfully'))
                                                ->icon('heroicon-o-document-text')
                                                ->iconColor('success')
                                                ->send();
                                            }),
                                        Action::make('reopenDiscussion')
                                            ->label(trans('dash.reopen_discussion'))
                                            ->requiresConfirmation()
                                            ->action(function (Quota $record) {
                                                $record->discussion->update(['is_open'=>true]);
                                                Notification::make()
                                                ->title(trans('dash.discussion_reopened_successfully'))
                                                ->icon('heroicon-o-document-text')
                                                ->iconColor('success')
                                                ->send();
                                            }),
                                    ])

                        
                            ]),
                // \Filament\Infolists\Components\Section::make(trans('dash.account_ballance'))
                //         ->columns(2)
                //         ->id('account_ballance-section')
                //         ->schema([
                //                 TextEntry::make('balance')->label(trans('dash.account_ballance_actual'))
                //                 ->color('primary')
                //                 ->size(TextEntry\TextEntrySize::Large)
                //                 ->weight(FontWeight::Bold)
                //                 ->tooltip(function (TextEntry $component): ?string {
                                    
                //                     return trans('dash.balance_calculate_method');
                //                 })
                       
                //         ]),
                       
            ]);
    }
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuotas::route('/'),
            'create' => Pages\CreateQuota::route('/create'),
            'edit' => Pages\EditQuota::route('/{record}/edit'),
            'view' => Pages\ViewAdminQuota::route('/{record}'),
        ];
    }
}
