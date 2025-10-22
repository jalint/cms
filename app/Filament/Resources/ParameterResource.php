<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ParameterResource\Pages;
use App\Filament\Resources\ParameterResource\RelationManagers;
use App\Models\Parameter;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ParameterResource extends Resource
{
    protected static ?string $model = Parameter::class;

    protected static ?string $navigationIcon = "heroicon-o-variable";

    protected static ?string $navigationGroup = "About Us";

    public static function form(Form $form): Form
    {
        return $form->schema([
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
            Forms\Components\Textarea::make("description_id")
                ->label("Description (ID)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\Textarea::make("description_en")
                ->label("Description (EN)")
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("badge_id")
                    ->label("Badge (ID)")
                    ->searchable(),

                Tables\Columns\TextColumn::make("title_id")
                    ->limit(50)
                    ->label("Title (ID)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("description_id")
                    ->label("Description (ID)")
                    ->limit(50)
                    ->searchable(),
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
        return [RelationManagers\ParametersValuesRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListParameters::route("/"),
            "create" => Pages\CreateParameter::route("/create"),
            "edit" => Pages\EditParameter::route("/{record}/edit"),
        ];
    }
}
