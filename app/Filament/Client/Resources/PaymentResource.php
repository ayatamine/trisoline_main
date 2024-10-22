<?php

namespace App\Filament\Client\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Payment;
use Filament\Forms\Get;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Wizard\Step;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Client\Resources\PaymentResource\Pages;
use App\Filament\Client\Resources\PaymentResource\RelationManagers;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'icon-payments';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('')
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make('destination_bank_account_type')->label(trans('dash.destination_bank_account_type'))
                                ->schema([
                                    Forms\Components\Select::make('bank_account_type')->label(trans('dash.choose_our_bank_type'))
                                    ->options([
                                        'CNY'=>trans('dash.cny'),
                                        'USD'=>trans_choice('dash.usd',1)
                                    ])
                                    ->default('order'),
                                    
                                ]),
                            Wizard\Step::make('payment_details')->label(trans('dash.payment_details'))
                                ->schema([
                                    Forms\Components\Select::make('type')->label(trans_choice('dash.type',1))
                                    ->options([
                                        'direct'=>trans('dash.direct'),
                                        'order'=>trans_choice('dash.order',1)
                                    ])
                                    ->default('order')
                                    ->live(),
                                    Forms\Components\Select::make('order_id')->label(trans_choice('dash.order',1))
                                        ->live()
                                        ->relationship('order','name')
                                        ->visible(fn(Get $get)=>$get('type') == 'order')
                                        ->preload(),
                                    Forms\Components\TextInput::make('payment_reason')->label(trans('dash.payment_reason'))
                                        ->visible(fn(Get $get)=>$get('type') == 'direct')
                                        ->required(),
                                    Forms\Components\TextInput::make('amount')->label(trans('dash.amount'))
                                        ->numeric()
                                        ->required(),
                                    Forms\Components\DatePicker::make('transfered_at')->label(trans('dash.transfered_at'))
                                        ->required(),
                                    Forms\Components\FileUpload::make('documents')->label(trans('dash.documents'))
                                        ->multiple()
                                        ->directory('clients_payments'),
                                ]),
                            Step::make('your_account_details')->label(trans('dash.your_bank_account_details'))
                                ->schema([
                                    Forms\Components\TextInput::make('bank_name')->label(trans('dash.bank_name')),
                                    Forms\Components\TextInput::make('account_number')->label(trans('dash.account_number')),
                                    Forms\Components\TextInput::make('swift_code')->label(trans('dash.swift_code')),
                                    Forms\Components\TextInput::make('beneficiary_name')->label(trans('dash.beneficiary_name')),
                                    Forms\Components\TextInput::make('beneficiary_address')->label(trans('dash.beneficiary_address')),
                                ]),
                        ])
                       
                        
                       
                        
                        
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_account_type')->label(trans('dash.destination_bank_account_type'))
                    ->formatStateUsing(fn($state)=>trans("dash.".Str::lower($state)."")),
                Tables\Columns\TextColumn::make('type')->label(trans('dash.payment_type'))
                    ->formatStateUsing(fn($state)=>trans("dash.$state")),
                Tables\Columns\TextColumn::make('payment_reason')->label(trans('dash.payment_reason'))
                    ->visible(fn(Payment $payment)=> $payment->type == 'direct')
                    ->searchable(),
                Tables\Columns\TextColumn::make('order.name')->label(trans_choice('dash.order',1))
                    ->visible(fn(Payment $payment)=> $payment->type == 'order')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')->label(trans('dash.amount'))->label(trans('dash.amount'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')->label(trans('dash.status'))
                    ->badge()
                    ->colors([
                        'pending' => 'info',
                        'approved' => 'success',
                        'received' => 'success',
                        'rejected' => 'danger',
                        'refunded' => 'warning',
                ]),
                Tables\Columns\TextColumn::make('transfered_at')->label(trans('dash.transfered_at'))
                    ->date()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('arrived_at')->label(trans('dash.arrived_at'))
                    ->date()
                    ->sortable()
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('status')->label(trans('dash.status'))->options([
                    'pending' => trans('dash.pending'),
                    'received' => trans('dash.received'),
                    'approved' => trans('dash.approved'),
                    'rejected' => trans('dash.rejected'),
                    'refunded' => trans('dash.refunded'),
                ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->visible(fn(Payment $payment)=>$payment->status == "pending"),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'view' => Pages\ViewPayment::route('/{record}'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
