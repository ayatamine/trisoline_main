<?php

namespace App\Filament\Admin\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Setting;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Forms\Components\TagsInput;
use Filament\Resources\Resource;
use Filament\Forms\Components\Tabs;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Admin\Resources\SettingResource\Pages;
use App\Filament\Admin\Resources\SettingResource\RelationManagers;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'icon-settings';
    protected static bool $shouldRegisterNavigation = false; 
    protected static ?string $slug = 'website-settings';

    public static function canCreate():bool
    {
        return false;
    }
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                        Tabs::make('Tabs')
                        ->tabs([
                                Tabs\Tab::make('General Settings')
                                ->icon('icon-settings')
                                ->schema([
                                    Forms\Components\TextInput::make('app_name')
                                        ->required()
                                        ->maxLength(255),
                                    
                                    Forms\Components\TextInput::make('phone_number')
                                        ->tel()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('turkey_phone_number')
                                        ->tel()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('address')
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('contact_email')
                                        ->email()
                                        ->required()
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('facebook_link')
                                        ->maxLength(255)
                                        ->url(),
                                    Forms\Components\TextInput::make('youtube_link')
                                        ->maxLength(255)
                                        ->url(),
                                    Forms\Components\TextInput::make('instagram_link')
                                        ->maxLength(255)
                                        ->url(),
                                    Forms\Components\TextInput::make('linkedin_link')
                                        ->maxLength(255)
                                        ->url(),
                                    Forms\Components\TextInput::make('twitter_link')
                                        ->maxLength(255)
                                        ->url(),
                                    Forms\Components\FileUpload::make('app_logo')
                                        ->image()
                                        ->preserveFilenames()
                                        ->imageEditor()
                                        ->imageEditorViewportWidth('800')
                                        ->imageEditorViewportHeight('300'),
                                    Forms\Components\TextInput::make('whatsapp_number')
                                        ->maxLength(255),
                                ]),
                                Tabs\Tab::make('Landing page Content')
                                ->icon('icon-landing_page')
                                ->schema([
                                    Forms\Components\TextInput::make('video_section_link')
                                        ->maxLength(255),
                                    Forms\Components\RichEditor::make('intro_text')
                                        ->maxLength(16777215)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('intro_text_ar')->label('Intro Text (Arabic)')
                                        ->maxLength(167755)
                                        ->columnSpanFull(),
                                    Forms\Components\TagsInput::make('intro_sliding_words')
                                        ->columnSpanFull(),
                                    Forms\Components\TagsInput::make('intro_sliding_words_ar')->label('Intro Sliding Words (Arabic)')
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('about_text')
                                        ->maxLength(167775)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('about_text_ar')->label('About Text (Arabic)')
                                        ->maxLength(167715)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('vision_text')
                                        ->maxLength(167715)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('vision_text_ar')->label('Vision Text (Arabic)')
                                        ->maxLength(167715)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('goals_text')
                                        ->maxLength(167215)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('goals_text_ar')->label('Goals Text (Arabic)')
                                        ->maxLength(167215)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('values_text')
                                        ->maxLength(167715)
                                        ->columnSpanFull(),
                                    Forms\Components\RichEditor::make('values_text_ar')->label('Values Text (Arabic)')
                                        ->maxLength(167715)
                                        ->columnSpanFull(),
                                    Forms\Components\Toggle::make('show_projects_section'),
                                    Forms\Components\Toggle::make('show_testimonials_section'),
                                    Forms\Components\Toggle::make('show_blog_section')
                                ]),
                                Tabs\Tab::make('SEO Settings')
                                ->icon('icon-seo')
                                ->schema([
                                    Forms\Components\Select::make('default_lang')
                                    ->options(['ar'=>'Arabic','en'=>'English'])
                                    ->default('ar'),
                                    
                                    Forms\Components\TextInput::make('meta_title')
                                        ->maxLength(255),
                                    Forms\Components\TextInput::make('meta_description')
                                        ->maxLength(255),
                                    Forms\Components\TagsInput::make('meta_keywords')
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('meta_image')
                                        ->preserveFilenames()
                                        ->columnSpanFull(),
                                    Forms\Components\FileUpload::make('favicon')
                                        ->preserveFilenames()
                                        ->columnSpanFull(),
                                ])
                            ])
                            ->columnSpanFull(),

                
        

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('app_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('app_logo')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('turkey_phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contact_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('facebook_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('youtube_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instagram_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('linkedin_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('twitter_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('whatsapp_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('video_section_link')
                    ->searchable(),
                Tables\Columns\TextColumn::make('default_lang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
