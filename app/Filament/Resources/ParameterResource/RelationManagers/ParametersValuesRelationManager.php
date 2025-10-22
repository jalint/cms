<?php

namespace App\Filament\Resources\ParameterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ParametersValuesRelationManager extends RelationManager
{
    protected static string $relationship = 'parameterValues';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('year')
                 ->label('Year')
                 ->options(function () {
                     $years = range(date('Y'), date('Y') - 100);

                     return array_combine($years, $years);
                 })
                 ->searchable()
                 ->unique()
                 ->required(),
                Forms\Components\TextInput::make('value')
                ->label('Value')
                ->required()
                ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('value'),
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
