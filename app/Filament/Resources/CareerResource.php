<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerResource\Pages;
use App\Models\Career;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CareerResource extends Resource
{
    protected static ?string $model = Career::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-plus';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('field_name_id')
                ->label('Field Name (ID)')
                ->required()
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn (Set $set, ?string $state) => $set(
                        'slug_id',
                        Str::slug($state),
                    ),
                )
                ->maxLength(255),
            Forms\Components\TextInput::make('field_name_en')
                ->label('Field Name (EN)')
                ->live(onBlur: true)
                ->afterStateUpdated(
                    fn (Set $set, ?string $state) => $set(
                        'slug_en',
                        Str::slug($state),
                    ),
                )
                ->maxLength(255),
            Forms\Components\TextInput::make('major_id')
                ->label('Major (ID)')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('major_en')
                ->label('Major (EN)')
                ->maxLength(255),
            Forms\Components\TextInput::make('location')
                ->label('Location')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('slug_id')
               ->label('Slug')
               ->required()
               ->disabled()
               ->dehydrated()
               ->maxLength(255),
            Forms\Components\TextInput::make('slug_en')
                ->label('Slug')
                ->required()
                ->disabled()
                ->dehydrated()
                ->hidden()
                ->maxLength(255),
            // Forms\Components\TextInput::make('employment_status'),
            RichEditor::make('description_id')
                ->label('Deescription (ID)')
                ->required()
                ->columnSpanFull(),
            RichEditor::make('description_en')
                ->label('Deescription (EN)')
                ->translatable()
                ->columnSpanFull(),
            Select::make('employment_status')
                ->options([
                    'full_time' => 'Full Time',
                    'part_time' => 'Part Time',
                    'contract' => 'Contract',
                    'intern' => 'Intern',
                    'freelance' => 'Freelance',
                ])
                ->required(),
            Forms\Components\TextInput::make('google_form_link')
                ->required()
                ->maxLength(255),
            Forms\Components\Toggle::make('is_active')->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('field_name_id')
                    ->label('Field Name (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('major_id')
                    ->label('Major (ID)')
                    ->searchable(),
                Tables\Columns\TextColumn::make('employment_status'),
                Tables\Columns\TextColumn::make(
                    'google_form_link',
                )->searchable(),
                Tables\Columns\IconColumn::make('is_active')->boolean(),
            ])
            ->filters([
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCareers::route('/'),
            'create' => Pages\CreateCareer::route('/create'),
            'edit' => Pages\EditCareer::route('/{record}/edit'),
        ];
    }
}
