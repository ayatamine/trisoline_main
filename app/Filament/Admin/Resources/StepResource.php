<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StepResource\Pages;
use App\Filament\Admin\Resources\StepResource\RelationManagers;
use App\Models\Step;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StepResource extends Resource
{
    protected static ?string $model = Step::class;

    protected static ?string $navigationIcon = 'icon-steps';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Title (En)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_ar')->label('Title (Ar)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')->label('Description (En)')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
             
                Forms\Components\RichEditor::make('description_ar')->label('Description (Ar)')
                    ->required()
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('svg')
                    ->preserveFilenames()
                    ->required(),
                Forms\Components\Select::make('step_order')
                    ->options([1,2,3,4,5,6,7,8,9,10])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Title (En)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_ar')->label('Title (Ar)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('step_order')->label('Step Order')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
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
            'index' => Pages\ListSteps::route('/'),
            'create' => Pages\CreateStep::route('/create'),
            'edit' => Pages\EditStep::route('/{record}/edit'),
        ];
    }
}
