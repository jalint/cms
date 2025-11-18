<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HomepageCardResource\Pages;
use App\Models\HomepageCard;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class HomepageCardResource extends Resource
{
    protected static ?string $model = HomepageCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-8-tooth';

    protected static ?string $navigationGroup = 'Beranda';
    protected static ?string $navigationLabel = 'Cards';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('homepage_service_id')
                    ->label('Homepage Service')
                    ->relationship('homepageService', 'badge_id', fn ($query) => $query->where('id', '!=', 6)) // 'name' adalah kolom yang ditampilkan
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->badge_id} - {$record->position}")
                    ->required()
                    ->searchable()
                    ->preload()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('metrics')
                    ->nullable()
                    ->maxLength(255)
                     ->columnSpanFull(),
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
                    ->columnSpanFull()->maxLength(157),
                Forms\Components\Textarea::make('description_en')
                 ->label('Description (EN)')
                    ->translatable()
                    ->required()
                    ->columnSpanFull()->maxLength(157),
                FileUpload::make('icon')->label('Icon/Gambar')->required()->acceptedFileTypes(['image/png', 'image/jpeg'])
                    ->helperText('Hanya bisa upload file PNG atau JPG.')->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('homepageService.badge_id')
                    ->label('Homepage Service')
                    ->formatStateUsing(fn ($record) => "{$record->homepageService->badge_id} - Position: {$record->homepageService->position}"
                    )
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('metrics')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description_id')
                 ->label('Description (ID)')
                 ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('homepageService')
                    ->relationship('homepageService', 'badge_id')
                    ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->badge_id}-{$record->position}"
                    ),
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
            'index' => Pages\ListHomepageCards::route('/'),
            'create' => Pages\CreateHomepageCard::route('/create'),
            'edit' => Pages\EditHomepageCard::route('/{record}/edit'),
        ];
    }
}
