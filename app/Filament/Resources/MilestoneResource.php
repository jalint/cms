<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MilestoneResource\Pages;
use App\Filament\Resources\MilestoneResource\RelationManagers;
use App\Models\Milestone;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MilestoneResource extends Resource
{
    protected static ?string $model = Milestone::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-trending-up';

    protected static ?string $navigationGroup = 'About Us';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title_id')
                ->label('Title (ID)')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('description_id')
                ->label('Description (ID)')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('description_en')
                ->label('Description (EN)')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')->label('Title (ID)')->searchable(),
                Tables\Columns\TextColumn::make('title_en')->label('Title (EN)')->searchable(),
                Tables\Columns\TextColumn::make('description_id')->label('Description (ID)')->searchable(),
                Tables\Columns\TextColumn::make('description_en')->label('Description (EN)')->searchable(),
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
        return [RelationManagers\MilestoneDetailsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMilestones::route('/'),
            'create' => Pages\CreateMilestone::route('/create'),
            'edit' => Pages\EditMilestone::route('/{record}/edit'),
        ];
    }
}
