<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    protected static ?string $navigationGroup = 'Our Clients';

    protected static ?string $navigationLabel = 'Page Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('hero_title_id')
                    ->label('Hero Title (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('hero_title_en')
                    ->label('Hero Title (EN)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_id')
                    ->label('Title (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_id')
                    ->label('Description (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('hero_title_id')
                    ->label('Hero Title (ID)'),
                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_id')
                    ->label('Description (ID)')
                    ->limit(50)
                    ->searchable(),
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
                // Tables\Columns\TextColumn::make('updated_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
