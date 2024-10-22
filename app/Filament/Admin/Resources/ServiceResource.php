<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ServiceResource\Pages;
use App\Filament\Admin\Resources\ServiceResource\RelationManagers;
use App\Models\Service;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static ?string $navigationIcon = 'icon-services';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')->label('Title (En)')
                ->required()
                ->maxLength(45),
            Forms\Components\TextInput::make('title_ar')->label('Title (AR)')
                ->required()
                ->maxLength(45),
            Forms\Components\RichEditor::make('description')->label('Description (En)')
                ->required()
                ->maxLength(11180)
                ->columnSpanFull(),
            Forms\Components\RichEditor::make('description_ar')->label('Description (AR)')
                ->required()
                ->maxLength(11180)
                ->columnSpanFull(),
            Forms\Components\FileUpload::make('image')
                ->image()
                ->directory('services')->preserveFilenames()->imageEditor()
                ->imageEditorViewportWidth('1280')
                ->imageEditorViewportHeight('853')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
               Tables\Columns\TextColumn::make('title')->label('Title (En)')
                    ->searchable()->sortable(),
                Tables\Columns\TextColumn::make('title_ar')->label('Title (AR)')
                    ->searchable()->sortable(),
                Tables\Columns\ImageColumn::make('image'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListServices::route('/'),
            'create' => Pages\CreateService::route('/create'),
            'edit' => Pages\EditService::route('/{record}/edit'),
        ];
    }
}
