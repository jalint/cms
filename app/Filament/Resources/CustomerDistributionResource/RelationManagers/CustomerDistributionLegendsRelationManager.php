<?php

namespace App\Filament\Resources\CustomerDistributionResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
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
                Tables\Actions\CreateAction::make()->createAnother(false)->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/profil-perusahaan&secret=JLIJayaSelalu');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/profil-perusahaan&secret=JLIJayaSelalu');
                }),
                Tables\Actions\DeleteAction::make()->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/profil-perusahaan&secret=JLIJayaSelalu');
                }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
