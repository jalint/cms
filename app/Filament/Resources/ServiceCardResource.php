<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ServiceCardResource\Pages;
use App\Filament\Resources\ServiceCardResource\RelationManagers;
use App\Models\ServiceCard;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ServiceCardResource extends Resource
{
    protected static ?string $model = ServiceCard::class;

    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';

    protected static ?string $navigationGroup = 'Layanan & Jasa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tab_id')
                    ->relationship('tab', 'tab_name_id')
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        // Pastikan relasi 'laboratorium' sudah didefinisikan di model Tab
                        return "{$record->serviceCategory->category_name_id} ({$record->tab_name_id})";
                    })
                    ->required(),
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->relationship('parentSelect', 'title_id')
                    ->preload()
                    ->nullable(),
                Forms\Components\TextInput::make('title_id')
                   ->label('Title (ID)')
                   ->required()
                   ->maxLength(255)->live(onBlur: true)
                    ->afterStateUpdated(
                        fn (Set $set, ?string $state) => $set(
                            'slug_id',
                            Str::slug($state),
                        ),
                    ),
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(
                        fn (Set $set, ?string $state) => $set(
                            'slug_en',
                            Str::slug($state),
                        ),
                    ),
                Forms\Components\TextInput::make('slug_id')
                ->label('Slug (ID)')
                ->required()
                ->disabled()
                ->dehydrated()
                ->maxLength(255),
                Forms\Components\TextInput::make('slug_en')
                    ->label('Slug (EN)')
                    ->required()
                    ->disabled()
                    ->dehydrated()
                    ->maxLength(255),
                FileUpload::make('background')
                    ->label('Background Card')
                    ->columnSpanFull()
                    ->required(),
                FileUpload::make('image')
                    ->label('Image')
                    ->nullable()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('badge_id')
                   ->label('Badge (ID)')
                   ->required()
                   ->maxLength(255),
                Forms\Components\TextInput::make('badge_en')
                    ->label('Badge (EN)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description_id')
                   ->label('Description (ID)')
                   ->required(),
                Forms\Components\RichEditor::make('description_en')
                   ->label('Description (EN)')
                   ->translatable()
                   ->required(),
                Forms\Components\RichEditor::make('sub_description_id')
                   ->label('Sub Description (ID)')
                   ->nullable(),
                Forms\Components\RichEditor::make('sub_description_en')
                    ->label('Sub Description (EN)')
                    ->translatable()
                    ->nullable(),
                Forms\Components\RichEditor::make('sub_description_one_id')
                   ->label('Sub Description_One (ID)')
                   ->nullable(),
                Forms\Components\RichEditor::make('sub_description_one_en')
                    ->label('Sub Description_One (EN)')
                    ->translatable()
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')
                  ->label('Title (ID)')
                  ->limit(50)
                  ->searchable(),
                Tables\Columns\TextColumn::make('tab.tab_name_id')   // relasi "tab" ambil kolom "tab_name"
                  ->label('Tab')
                  ->searchable()
                  ->sortable(),
                Tables\Columns\TextColumn::make('parent.title_id')   // relasi "tab" ambil kolom "tab_name"
                  ->label('Parent')
                  ->searchable()
                  ->sortable(),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ServiceMediaCardsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListServiceCards::route('/'),
            'create' => Pages\CreateServiceCard::route('/create'),
            'edit' => Pages\EditServiceCard::route('/{record}/edit'),
        ];
    }
}
