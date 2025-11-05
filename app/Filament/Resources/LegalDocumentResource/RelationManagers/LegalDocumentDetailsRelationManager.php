<?php

namespace App\Filament\Resources\LegalDocumentResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class LegalDocumentDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'legalDocumentDetails';

    public function form(Form $form): Form
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
            FileUpload::make('banner')->required(),
            FileUpload::make('file')->label('File')->required(),
            Forms\Components\Toggle::make('is_highlight'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')->label(
                    'Title (ID)',
                ),
                Tables\Columns\TextColumn::make('description_id')->label(
                    'Description (ID)',
                ),
                Tables\Columns\IconColumn::make('file')
                    ->label('File')
                    ->icon(
                        fn ($record) => match (
                            pathinfo($record->file, PATHINFO_EXTENSION)
                        ) {
                            'pdf' => 'heroicon-o-document-text',
                            'jpg', 'jpeg', 'png' => 'heroicon-o-photo',
                            'doc', 'docx' => 'heroicon-o-document',
                            'xls', 'xlsx' => 'heroicon-o-table-cells',
                            default => 'heroicon-o-document',
                        },
                    )
                    ->url(
                        fn ($record) => $record->file_path
                            ? Storage::url($record->file_path)
                            : null,
                    )
                    ->openUrlInNewTab()
                    ->tooltip(
                        fn ($record) => $record->file_path
                            ? basename($record->file_path)
                            : 'No file',
                    ),
                Tables\Columns\IconColumn::make('is_highlight')->boolean(),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false)->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/legalitas-perusahaan&secret=JLIJayaSelalu');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
