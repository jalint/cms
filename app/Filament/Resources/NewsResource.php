<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\News;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;

use App\Filament\Resources\NewsResource\Pages;

class NewsResource extends Resource
{
    protected static ?string $model = News::class;

    protected static ?string $navigationIcon = "heroicon-o-newspaper";

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("title_id")
                ->label("Title (ID)")
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn(Set $set, ?string $state) => $set(
                        "slug_id",
                        Str::slug($state),
                    ),
                )
                ->maxLength(255),
            Forms\Components\TextInput::make("title_en")
                ->label("Title (EN)")
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn(Set $set, ?string $state) => $set(
                        "slug_en",
                        Str::slug($state),
                    ),
                )
                ->maxLength(255),
            Forms\Components\TextInput::make("slug_id")
                ->label("Slug (ID)")
                ->required()
                ->disabled()
                ->dehydrated()
                ->maxLength(255),
            Forms\Components\TextInput::make("slug_en")
                ->label("Slug (EN)")
                ->required()
                ->disabled()
                ->dehydrated()
                ->maxLength(255),
            Forms\Components\RichEditor::make("content_id")
                ->label("Content (ID)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("content_en")
                ->label("Content (EN)")
                ->translatable()
                ->required()
                ->columnSpanFull(),
            FileUpload::make("url_image")
                ->label("Photo")
                ->columnSpanFull()
                ->required(),
            Forms\Components\Toggle::make("is_publish")->required(),
            Forms\Components\Toggle::make("is_highlight")->required(),
            // Forms\Components\Toggle::make('is_auto_translate')
            //     ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title_id")
                    ->label("Title (ID)")
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\IconColumn::make("is_highlight")
                    ->label("Highlight")
                    ->boolean(),
                Tables\Columns\TextColumn::make("view_count")
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make("is_publish")
                    ->label("Publish")
                    ->boolean(),
                Tables\Columns\TextColumn::make("created_at")
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make("updated_at")
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
        return [
                //
            ];
    }

    public static function getPages(): array
    {
        return [
            "index" => Pages\ListNews::route("/"),
            "create" => Pages\CreateNews::route("/create"),
            "edit" => Pages\EditNews::route("/{record}/edit"),
        ];
    }
}
