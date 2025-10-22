<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageServiceResource\Pages;
use App\Filament\Resources\HomepageServiceResource\RelationManagers;
use App\Models\HomepageService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HomepageServiceResource extends Resource
{
    protected static ?string $model = HomepageService::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationGroup = 'Homepage Settings';
    protected static ?string $navigationLabel = 'Services';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('position')
                    ->required()
                    ->disabled()
                    ->numeric()->columnSpanFull(),
                Forms\Components\TextInput::make('badge_id')
                    ->label('Badge (ID)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('badge_en')
                   ->label('Badge (EN)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('title_id')
                   ->label('Title (ID)')
                    ->required(),
                Forms\Components\Textarea::make('title_en')
                  ->label('Title (EN)')
                    ->required(),
                Forms\Components\Textarea::make('description_id')
                  ->label('Description (ID)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_en')
                    ->translatable()
                    ->label('Description (EN)')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('position')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('badge_id')
                ->label('Badge (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('badge_en')
                   ->label('Badge (EN)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_id')
                          ->words(10)
                   ->label('Description (ID)')
                    ->searchable(),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomepageServices::route('/'),
            'create' => Pages\CreateHomepageService::route('/create'),
            'edit' => Pages\EditHomepageService::route('/{record}/edit'),
        ];
    }
}
