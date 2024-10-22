<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use App\Models\ProjectType;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\ProjectResource\Pages;
use App\Filament\Admin\Resources\ProjectResource\RelationManagers;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'icon-portfolio';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('types')->label('Category')
                 ->multiple()
                 ->searchable(['title', 'title_ar'])
                 ->relationship(name: 'types', titleAttribute: 'title')
                 ->preload()
                 ->getOptionLabelFromRecordUsing(fn (ProjectType $record) => "{$record->title} - {$record->title_ar}")
                 ->createOptionForm([
                    Forms\Components\TextInput::make('title')->label('Title (En)')
                        ->required()
                        ->maxLength(100),
                    Forms\Components\TextInput::make('title_ar')->label('Title (AR)')
                        ->required()
                        ->maxLength(100),
                ]),

                Forms\Components\TextInput::make('title')->label('Title (En)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_ar')->label('Title (Ar)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('thumbnail')
                    ->image()
                    ->directory('portfolio')->preserveFilenames()->imageEditor()
                    ->imageEditorViewportWidth('800')
                    ->imageEditorViewportHeight('600'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_ar')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->searchable(),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
