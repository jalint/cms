<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\HomepageTestimonial;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\HomepageTestimonialResource\Pages;
use App\Filament\Resources\HomepageTestimonialResource\RelationManagers;

class HomepageTestimonialResource extends Resource
{
    protected static ?string $model = HomepageTestimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationGroup = 'Homepage Settings';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Testimonials';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('photo')->required(),
                FileUpload::make('customer_logo')->required(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('job_title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_id')
                    ->label('Description (ID)')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->translatable()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->required()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('job_title')
                    ->searchable(),
                   Tables\Columns\TextColumn::make('description_id')
                    ->label('Description (ID)')
                    ->limit(50)
                    ->searchable(),
                 Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHomepageTestimonials::route('/'),
            'create' => Pages\CreateHomepageTestimonial::route('/create'),
            'edit' => Pages\EditHomepageTestimonial::route('/{record}/edit'),
        ];
    }
}
