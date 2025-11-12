<?php

namespace App\Filament\Resources\MilestoneResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class MilestoneDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'milestoneDetails';

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
                            ->rules(function ($get, $record) {
                                return [
                                    'required',
                                    Rule::unique('milestone_details', 'year')->ignore($record),
                                ];
                            })
                 ->searchable()
                 ->required(),
                FileUpload::make('image')
                    ->label('Photo')
                    ->required(),
                Forms\Components\TextInput::make('title_id')
                    ->label('Title (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description_id')
                    ->label('Description (ID)')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            // ->recordTitleAttribute('tahun')
            ->columns([
                Tables\Columns\TextColumn::make('year'),
                Tables\Columns\TextColumn::make('title_id')->label('Title (ID)'),
                Tables\Columns\TextColumn::make('description_id')->limit(50)->label('Description (ID)'),
                // Tables\Columns\TextColumn::make('year'),
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
