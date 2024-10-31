<?php

namespace App\Filament\Admin\Resources;

use Closure;
use Filament\Forms;
use App\Models\User;
use Filament\Tables;
use App\Models\Client;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ClientResource\Pages;
use App\Filament\Admin\Resources\ClientResource\RelationManagers;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'icon-clients';
    protected static ?string $navigationGroup = 'Admin';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label(trans('dash.name'))
                            ->required(),
                        Forms\Components\TextInput::make('email')
                            ->label(trans('dash.email'))
                            ->email()
                            ->required()
                            ->rules([
                                fn (Client $client): Closure => function (string $attribute, $value, Closure $fail) use ($client) {
                                    if($client?->id)
                                    {
                                        if (User::whereEmail($value)->whereNot('id',$client->user_id)->first() ) {
                                            $fail('email has been already registered');
                                        }
                                    }else{
                                        if (User::whereNationalId($value)->first() ) {
                                            $fail('email has been already registered');
                                        }
                                    }
                                    
                                },
                            ]),
                        Forms\Components\TextInput::make('password')
                            ->label(trans('dash.password'))
                            ->password()
                            ->required(fn(Client $client)=> !$client)
                            ->revealable()

                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label(trans('dash.name'))
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.email')->label(trans('dash.email'))
                    ->searchable()
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
