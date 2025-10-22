<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerDistributionResource\Pages;
use App\Filament\Resources\CustomerDistributionResource\RelationManagers;
use App\Models\CustomerDistribution;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerDistributionResource extends Resource
{
    protected static ?string $model = CustomerDistribution::class;

    protected static ?string $navigationIcon = "heroicon-o-user";

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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("badge_id")
                    ->searchable()
                    ->label("Badge (ID)"),
                Tables\Columns\TextColumn::make("badge_en")
                    ->label("Badge (EN)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("title_id")
                    ->label("Title (ID)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("title_en")
                    ->label("Title (EN)")
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
        return [
            RelationManagers\CustomerDistributionLegendsRelationManager::class,
            RelationManagers\CustomerDistributionDatasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListCustomerDistributions::route("/"),
            "create" => Pages\CreateCustomerDistribution::route("/create"),
            "edit" => Pages\EditCustomerDistribution::route("/{record}/edit"),
        ];
    }
}
