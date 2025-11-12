<?php

namespace App\Filament\Resources\CustomerDistributionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class CustomerDistributionLegendsRelationManager extends RelationManager
{
    protected static string $relationship = 'customerDistributionLegends';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                ColorPicker::make('hex')->label('Color')->required()
                           ->rules(function ($get, $record) {
                               return [
                                   'required',
                                   Rule::unique('customer_distribution_legends', 'hex')->ignore($record),
                               ];
                           }),
                Forms\Components\TextInput::make('legenda')
                 ->label('Legenda')
                 ->required()
                 ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                ColorColumn::make('hex')->label('Color'),
                Tables\Columns\TextColumn::make('legenda'),
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
