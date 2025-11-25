<?php

namespace App\Filament\Resources\ParameterResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

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
                ->rules(function ($get, $record) {
                    return [
                        'required',
                        Rule::unique('parameter_values', 'year')->ignore($record),
                    ];
                })
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
