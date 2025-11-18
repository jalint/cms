<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyPolicyResource\Pages;
use App\Filament\Resources\CompanyPolicyResource\RelationManagers;
use App\Models\CompanyPolicy;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyPolicyResource extends Resource
{
    protected static ?string $model = CompanyPolicy::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Tentang Kami';

    protected static ?int $navigationSort = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('hero_title_id')
                ->label('Hero Title (ID)')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('hero_title_en')
                ->label('Hero Title (EN)')
                ->required()
                ->maxLength(255),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title_id')
                    ->label('Hero Title (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('hero_title_en')
                    ->label('Hero Title (EN)')
                    ->searchable(),
            ])
            ->filters([
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [RelationManagers\CompanyPolicyDetailsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanyPolicies::route('/'),
            'create' => Pages\CreateCompanyPolicy::route('/create'),
            'edit' => Pages\EditCompanyPolicy::route('/{record}/edit'),
        ];
    }
}
