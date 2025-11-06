<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Klien Kami';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('corporate_group_id')
                    ->relationship('corporateGroup', 'name')
                    ->required(),
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\FileUpload::make('image')
                //     ->image()
                //     ->columnSpanFull()
                //     ->required(),

                RichEditor::make('description_id')
                   ->label('Description (ID)')
                   ->columnSpanFull()
                   ->required(),
                RichEditor::make('description_en')
                    ->label('Description (EN)')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('corporateGroup.name'),
            ])
            ->filters([
                SelectFilter::make('Corporate Group')
                ->relationship('corporateGroup', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
            ]);
    }

    public static function getRelations(): array
    {
        return [
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
