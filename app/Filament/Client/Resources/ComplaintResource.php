<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Complaint;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\ComplaintResource\Pages;
use App\Filament\Client\Resources\ComplaintResource\RelationManagers;

class ComplaintResource extends Resource
{
    protected static ?string $model = Complaint::class;

    protected static ?string $navigationIcon = 'icon-complaint';

    public static function form(Form $form): Form
    {
        // 'order_id',
        // 'reason',
        // 'content',
        // 'status',
        // 'resolution_summary',
        // 'resolved_by',
        // 'user_id',
        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('type')->label(trans('dash.complaint_type'))
                                    ->options([
                                        'order'=>trans_choice('dash.order',1),
                                        'payment'=>trans_choice('payment',1),
                                        'other'=>trans('dash.other')
                                    ])
                                    ->default('other')
                                    ->live(),
                        Forms\Components\Select::make('order_id')
                                    ->label(trans_choice('dash.order',1))
                                    ->options(Order::query()->whereClientId(request()->user()?->client->id)->pluck('name','id'))
                                    ->visible(fn(Get $get)=> $get('type') == 'order')
                                    ->required(),
                        Forms\Components\Select::make('payment_id')
                                    ->label(trans_choice('dash.payment',1))
                                    ->options(Payment::query()->whereClientId(request()->user()?->client->id)->pluck('full_title','id'))
                                    ->visible(fn(Get $get)=> $get('type') == 'payment')
                                    ->required(),
                        Forms\Components\Select::make('reason')
                                    ->label(trans('dash.complaint_reason'))
                                    ->options(
                                        [
                                            'goods not received after payment',
                                            'payment not received after delivery',
                                            'communication problems',
                                            'General help',
                                            'other'=>'other'
                                        ]
                                    )
                                    ->live()
                                    ->required()
                                    ->hiddenOn('edit'),
                        Forms\Components\TextInput::make('reason2')->label(trans('dash.complaint_reason'))
                                    ->visible(fn(Get $get)=> $get('reason') == 'other'),
                        Forms\Components\TextInput::make('reason2')->label(trans('dash.enter_another_reason'))
                                    ->visibleOn('edit'),
                        Forms\Components\Textarea::make('content')->label(trans('dash.content')),
                        Forms\Components\Textarea::make('resolution_summary')->label(trans('dash.resolution_summary'))
                                    ->visible(fn(Complaint $complaint)=> $complaint->resolution_summary != null),
                        Forms\Components\FileUpload::make('documents')->label(trans('dash.documents'))
                                    ->directory('complaints')
                                    ->preserveFilenames()
                                    ->multiple(),
                        
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order.name')->label(trans_choice('dash.order',1)),
                TextColumn::make('payment.name')->label(trans_choice('dash.payment',1)),
                TextColumn::make('reason')->label(trans('dash.complaint_reason'))->searchable(),
                TextColumn::make('content')->label(trans('dash.content'))->searchable()->limit(50),
                TextColumn::make('resolution_summary')->label(trans('dash.status'))
                            ->badge()
                            ->formatStateUsing(fn(string $state)=>$state==null ? "resolved" : "open"),
            ])
            ->filters([
                SelectFilter::make('type')->label(trans('dash.status'))->options([
                    'order'=>trans_choice('dash.order',1),
                    'payment'=>trans_choice('payment',1),
                    'other'=>trans('dash.other')
                ]),
                Filter::make('created_at')
                ->form([
                    Forms\Components\Select::make('type')->label(trans('dash.complaint_type'))
                    ->options([
                        'order'=>trans_choice('dash.order',1),
                        'payment'=>trans_choice('payment',1),
                        'other'=>trans('dash.other')
                    ])
                    ->default('other')
                    ->live(),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            $data['type'],
                            fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                        );
                })
            ])
            ->actions([
                Tables\Actions\Action::make('show_details')
                ->label(trans('dash.show_details'))
                ->icon('heroicon-o-eye')
                ->color('info')
                ->url(fn(Complaint $record)=>route('complaints.show',$record->id)),
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListComplaints::route('/'),
            'create' => Pages\CreateComplaint::route('/create'),
            'view' => Pages\ViewComplaint::route('/{record}'),
            'edit' => Pages\EditComplaint::route('/{record}/edit'),
        ];
    }
}
