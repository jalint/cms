<?php

namespace App\Filament\Resources\ServiceCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TabsRelationManager extends RelationManager
{
    protected static string $relationship = 'tabs';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('tab_name_id')
                    ->label('Tab Name (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('tab_name_en')
                    ->required()
                     ->label('Tab Name (EN)')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_id')
                    ->label('Description (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_en')
                    ->required()
                     ->label('Description (EN)')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('tab_name_id')->label('Tab Name (ID)'),
                Tables\Columns\TextColumn::make('tab_name_en')->label('Tab Name (EN)'),
                Tables\Columns\TextColumn::make('description_id')->label('Description (EN)')->limit(50),
                Tables\Columns\TextColumn::make('description_en')->label('Description (EN)')->limit(50),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
