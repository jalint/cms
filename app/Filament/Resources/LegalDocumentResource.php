<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalDocumentResource\Pages;
use App\Filament\Resources\LegalDocumentResource\RelationManagers;
use App\Models\LegalDocument;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class LegalDocumentResource extends Resource
{
    protected static ?string $model = LegalDocument::class;

    protected static ?string $navigationIcon = 'heroicon-o-document';

    protected static ?string $navigationGroup = 'Tentang Kami';

    protected static ?int $navigationSort = 7;

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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->searchable(),
            ])
            ->filters([
            ])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->after(function () {
                        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/legalitas-perusahaan&secret=JLIJayaSelalu');
                    }),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [RelationManagers\LegalDocumentDetailsRelationManager::class];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegalDocuments::route('/'),
            'create' => Pages\CreateLegalDocument::route('/create'),
            'edit' => Pages\EditLegalDocument::route('/{record}/edit'),
        ];
    }
}
