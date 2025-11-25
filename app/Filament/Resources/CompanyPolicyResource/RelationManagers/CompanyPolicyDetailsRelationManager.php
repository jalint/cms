<?php

namespace App\Filament\Resources\CompanyPolicyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;

class CompanyPolicyDetailsRelationManager extends RelationManager
{
    protected static string $relationship = 'companyPolicyDetails';

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
            Forms\Components\RichEditor::make('policy_id')
                ->label('Policy (ID)')
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make('policy_en')
                ->label('Policy (EN)')
                ->translatable()
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_id')
                    ->label('Title (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('policy_en')
                    ->label('Policy (EN)')
                    ->limit(50)
                    ->html(true)
                    ->searchable(),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false)->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/kebijakan-perusahaan&secret=JLIJayaSelalu');
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/kebijakan-perusahaan&secret=JLIJayaSelalu');
                }),
                Tables\Actions\DeleteAction::make()->after(function () {
                    Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/kebijakan-perusahaan&secret=JLIJayaSelalu');
                }),
            ])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
            ]);
    }
}
