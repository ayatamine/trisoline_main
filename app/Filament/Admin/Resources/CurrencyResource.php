<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\CurrencyResource\Pages;
use App\Filament\Admin\Resources\CurrencyResource\RelationManagers;
use App\Models\Currency;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CurrencyResource extends Resource
{
    protected static ?string $model = Currency::class;

    protected static ?string $navigationIcon = 'icon-currency';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(trans('dash.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('symbol')->label(trans('dash.symbol'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')->label(trans(key: 'dash.status'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(trans('dash.name'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('symbol')->label(trans('dash.symbol'))
                    ->searchable(),
                Tables\Columns\IconColumn::make(name: 'is_active')->label(trans('dash.status'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')->label(trans('dash.created_at'))
                    ->date()
                    ->sortable()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListCurrencies::route('/'),
            'create' => Pages\CreateCurrency::route('/create'),
            'edit' => Pages\EditCurrency::route('/{record}/edit'),
        ];
    }
}
