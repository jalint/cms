<?php

namespace App\Filament\Resources\DirectoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class DirectoryDetailsRelationManager extends RelationManager
{
    protected static string $relationship = "directoryDetails";

    public function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make("title_id")
                ->label("Title (ID)")
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make("title_en")
                ->label("Title (EN)")
                ->required()
                ->maxLength(255),
            FileUpload::make("icon")->required(),
            FileUpload::make("file_path")->label("File")->required(),
            Forms\Components\Toggle::make("is_active")->required(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title_id")->label(
                    "Title (ID)",
                ),
                Tables\Columns\TextColumn::make("title_en")->label(
                    "Title (EN)",
                ),
                Tables\Columns\IconColumn::make("file_path")
                    ->label("File")
                    ->icon(
                        fn($record) => match (
                            pathinfo($record->file_path, PATHINFO_EXTENSION)
                        ) {
                            "pdf" => "heroicon-o-document-text",
                            "jpg", "jpeg", "png" => "heroicon-o-photo",
                            "doc", "docx" => "heroicon-o-document",
                            "xls", "xlsx" => "heroicon-o-table-cells",
                            default => "heroicon-o-document",
                        },
                    )
                    ->url(
                        fn($record) => $record->file_path
                            ? Storage::url($record->file_path)
                            : null,
                    )
                    ->openUrlInNewTab()
                    ->tooltip(
                        fn($record) => $record->file_path
                            ? basename($record->file_path)
                            : "No file",
                    ),
                Tables\Columns\IconColumn::make("is_active")->boolean(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->recordAction(null)
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
