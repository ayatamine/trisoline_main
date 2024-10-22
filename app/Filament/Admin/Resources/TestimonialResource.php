<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TestimonialResource\Pages;
use App\Filament\Admin\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'icon-testimonials';
    protected static ?string $modelLabel = 'Client review';
    protected static ?string $pluralModelLabel  = 'Clients reviews';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Textarea::make('content')
                    ->required()
                    ->maxLength(400)
                    ->columnSpanFull()
                    ,
                Forms\Components\TextInput::make('client_name')
                    ->required()
                    ->maxLength(255)
                    ->default('Unknown'),
                Forms\Components\Select::make('client_country')
                    ->options([
                        "AF" => "Afghanistan",
                        "AM" => "Armenia",
                        "AZ" => "Azerbaijan",
                        "BH" => "Bahrain",
                        "BD" => "Bangladesh",
                        "BT" => "Bhutan",
                        "IO" => "British Indian Ocean Territory",
                        "BN" => "Brunei Darussalam",
                        "KH" => "Cambodia",
                        "CN" => "China",
                        "CX" => "Christmas Island",
                        "CC" => "Cocos (Keeling) Islands",
                        "CY" => "Cyprus",
                        "GE" => "Georgia",
                        "HK" => "Hong Kong",
                        "IN" => "India",
                        "ID" => "Indonesia",
                        "IR" => "Iran, Islamic Republic of",
                        "IQ" => "Iraq",
                        "IL" => "Israel",
                        "JP" => "Japan",
                        "JO" => "Jordan",
                        "KZ" => "Kazakhstan",
                        "KP" => "Korea, Democratic People's Republic of",
                        "KR" => "Korea, Republic of",
                        "KW" => "Kuwait",
                        "KG" => "Kyrgyzstan",
                        "LA" => "Lao People's Democratic Republic",
                        "LB" => "Lebanon",
                        "MO" => "Macao",
                        "MY" => "Malaysia",
                        "MV" => "Maldives",
                        "MN" => "Mongolia",
                        "MM" => "Myanmar",
                        "NP" => "Nepal",
                        "OM" => "Oman",
                        "PK" => "Pakistan",
                        "PS" => "Palestinian Territory, Occupied",
                        "PH" => "Philippines",
                        "QA" => "Qatar",
                        "RU" => "Russian Federation",
                        "SA" => "Saudi Arabia",
                        "SG" => "Singapore",
                        "LK" => "Sri Lanka",
                        "SY" => "Syrian Arab Republic",
                        "TW" => "Taiwan, Province of China",
                        "TJ" => "Tajikistan",
                        "TH" => "Thailand",
                        "TL" => "Timor-Leste",
                        "TR" => "Turkey",
                        "TM" => "Turkmenistan",
                        "AE" => "United Arab Emirates",
                        "UZ" => "Uzbekistan",
                        "VN" => "Viet Nam",
                        "YE" => "Yemen",
                        "DZ" => "Algeria",
                        "AO" => "Angola",
                        "BJ" => "Benin",
                        "BW" => "Botswana",
                        "BF" => "Burkina Faso",
                        "BI" => "Burundi",
                        "CM" => "Cameroon",
                        "CV" => "Cape Verde",
                        "CF" => "Central African Republic",
                        "TD" => "Chad",
                        "KM" => "Comoros",
                        "CG" => "Congo",
                        "CD" => "Congo, Democratic Republic of the Congo",
                        "CI" => "Cote D'Ivoire",
                        "DJ" => "Djibouti",
                        "EG" => "Egypt",
                        "GQ" => "Equatorial Guinea",
                        "ER" => "Eritrea",
                        "ET" => "Ethiopia",
                        "GA" => "Gabon",
                        "GM" => "Gambia",
                        "GH" => "Ghana",
                        "GN" => "Guinea",
                        "GW" => "Guinea-Bissau",
                        "KE" => "Kenya",
                        "LS" => "Lesotho",
                        "LR" => "Liberia",
                        "LY" => "Libyan Arab Jamahiriya",
                        "MG" => "Madagascar",
                        "MW" => "Malawi",
                        "ML" => "Mali",
                        "MR" => "Mauritania",
                        "MU" => "Mauritius",
                        "YT" => "Mayotte",
                        "MA" => "Morocco",
                        "MZ" => "Mozambique",
                        "NA" => "Namibia",
                        "NE" => "Niger",
                        "NG" => "Nigeria",
                        "RE" => "Reunion",
                        "RW" => "Rwanda",
                        "SH" => "Saint Helena",
                        "ST" => "Sao Tome and Principe",
                        "SN" => "Senegal",
                        "SC" => "Seychelles",
                        "SL" => "Sierra Leone",
                        "SO" => "Somalia",
                        "ZA" => "South Africa",
                        "SS" => "South Sudan",
                        "SD" => "Sudan",
                        "SZ" => "Swaziland",
                        "TZ" => "Tanzania, United Republic of",
                        "TG" => "Togo",
                        "TN" => "Tunisia",
                        "UG" => "Uganda",
                        "EH" => "Western Sahara",
                        "ZM" => "Zambia",
                        "ZW" => "Zimbabwe"
                ]),
                Forms\Components\FileUpload::make('client_thumbnail')
                    ->required()
                    ->directory('testimonials')
                    ->preserveFilenames(),
             
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([

                Tables\Columns\TextColumn::make('client_name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('client_thumbnail')
                    ->searchable(),
                Tables\Columns\TextColumn::make('client_country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
