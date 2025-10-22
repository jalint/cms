<?php

namespace App\Filament\Resources\CompanyPolicyResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class CompanyPolicyDetailsRelationManager extends RelationManager
{
    protected static string $relationship = "companyPolicyDetails";

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
            Forms\Components\RichEditor::make("policy_id")
                ->label("Policy (ID)")
                ->required()
                ->columnSpanFull(),
            Forms\Components\RichEditor::make("policy_en")
                ->label("Policy (EN)")
                ->translatable()
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make("title_id")
                    ->label("Title (ID)")
                    ->searchable(),
                Tables\Columns\TextColumn::make("policy_en")
                    ->label("Policy (EN)")
                    ->limit(50)
                    ->html(true)
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
