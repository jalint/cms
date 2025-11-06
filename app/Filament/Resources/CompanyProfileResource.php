<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyProfileResource\Pages;
use App\Models\CompanyProfile;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyProfileResource extends Resource
{
    protected static ?string $model = CompanyProfile::class;

    protected static ?string $navigationIcon = "heroicon-o-building-office";

    protected static ?string $navigationGroup = "Tentang Kami";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("hero_title_id")
                ->label("Hero Title (ID)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("hero_title_en")
                ->label("Hero Title (EN)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("badge_id")
                ->label("Badge (ID)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("badge_en")
                ->label("Badge (EN)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("title_id")
                ->label("Title (ID)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("title_en")
                ->label("Title (EN)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("description_id")
                ->label("Description (ID)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("description_en")
                ->label("Description (EN)")
                ->required()
                ->maxLength(255),
            Forms\Components\RichEditor::make("visi_id")
                ->label("Visi (ID)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("visi_en")
                ->label("Visi (EN)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("misi_id")
                ->label("Misi (ID)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("misi_en")
                ->label("Misi (EN)")
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("hero_title_id")
                    ->label("Hero Title (ID)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("badge_id")
                    ->label("Badge (ID)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("title_id")
                    ->label("Title (ID)")
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make("description_id")
                    ->label("Description (ID)")
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make("visi_id")
                    ->label("Visi (ID)")
                    ->limit(50)
                    ->searchable()
                    ->formatStateUsing(fn($state) => strip_tags($state)),
                Tables\Columns\TextColumn::make("misi_id")
                    ->label("Misi (ID)")
                    ->limit(50)
                    ->searchable()
                    ->formatStateUsing(fn($state) => strip_tags($state)),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCompanyProfiles::route("/"),
            "create" => Pages\CreateCompanyProfile::route("/create"),
            "edit" => Pages\EditCompanyProfile::route("/{record}/edit"),
        ];
    }
}
