<?php

namespace App\Filament\Resources\ServiceCardResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ServiceMediaCardsRelationManager extends RelationManager
{
    protected static string $relationship = 'serviceMediaCards';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title_id')
                    ->required()
                    ->label('Title (ID)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_en')
                    ->required()
                    ->label('Title (EN)')
                    ->maxLength(255),
                FileUpload::make('file')
                    ->label('File')
                    ->columnSpanFull()
                    ->required(),
                Forms\Components\TextInput::make('date')
                    ->required()
                    ->label('Date')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')->label('Title (ID)')->limit(50),
                Tables\Columns\TextColumn::make('title_en')->label('Title (EN)')->limit(50),
                Tables\Columns\TextColumn::make('file'),
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
