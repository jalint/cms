<?php

namespace App\Filament\Resources\CustomerDistributionResource\RelationManagers;

use Aliziodev\IndonesiaRegions\Facades\Indonesia;
use App\Models\IndonesiaRegion;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Validation\Rule;

class CustomerDistributionDatasRelationManager extends RelationManager
{
    protected static string $relationship = 'customerDistributionDatas';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('province_code')
    ->label('Provinsi')
    ->options(fn () => Indonesia::getRegions()   // kalau paketmu ada helper ini
        ->pluck('name', 'code')
        ->toArray()
    )
    // Jika paketmu tidak punya getProvinces(), kamu bisa:
//  ->options(fn () => Indonesia::getRegions(null, ['code','name'])
//      ->where('level', 'province')
//      ->pluck('name','code')
//      ->toArray()
//  )
    ->searchable()
    ->reactive()
    ->afterStateUpdated(function ($state, Set $set) {
        // reset kota saat provinsi berubah
        $set('city_code', null);

        if (!$state) {
            $set('name', null);
            $set('latitude', null);
            $set('longitude', null);

            return;
        }

        $prov = IndonesiaRegion::where('code', $state)->first();
        if ($prov) {
            $set('name', $prov->name);
            $set('latitude', $prov->latitude);
            $set('longitude', $prov->longitude);
        }
    })
    ->dehydrated(false),
                Select::make('city_code')
    ->label('Kota/Kabupaten')
    ->options(function (Get $get) {
        $provCode = $get('province_code');
        if (!$provCode) {
            return [];
        }

        // Ambil semua kota/kabupaten untuk provinsi terpilih
        return Indonesia::getRegions($provCode, ['code', 'name'])
            ->pluck('name', 'code')
            ->toArray();
    })
    ->searchable()
    ->reactive()
    ->afterStateUpdated(function ($state, Get $get, Set $set) {
        if (!$state) {
            // fallback ke data provinsi jika kota kosong
            $prov = $get('province_code')
                ? IndonesiaRegion::where('code', $get('province_code'))->first()
                : null;

            $set('name', $prov?->name);
            $set('latitude', $prov?->latitude);
            $set('longitude', $prov?->longitude);

            return;
        }

        $city = IndonesiaRegion::where('code', $state)->first();
        if ($city) {
            $set('name', $city->name);
            $set('latitude', $city->latitude);
            $set('longitude', $city->longitude);
        }
    })
    ->dehydrated(false),

                // Field penampung nilai yang akan disimpan ke DB:
                TextInput::make('name')
                    ->label('Nama Wilayah')
                               ->rules(function ($get, $record) {
                                   return [
                                       'required',
                                       Rule::unique('customer_distribution_datas', 'name')->ignore($record),
                                   ];
                               })
                    ->disabled()       // tidak bisa diedit manual
                    ->dehydrated(),  // tetap disubmit ke server

                TextInput::make('latitude')
                    ->label('Latitude')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                TextInput::make('longitude')
                    ->label('Longitude')
                    ->numeric()
                    ->disabled()
                    ->dehydrated(),

                Select::make('customer_distribution_legend_id')->label('Legenda')
    ->relationship(name: 'customerDistributionLegend', titleAttribute: 'legenda')
    ->searchable()->preload(),
                FileUpload::make('image')->required()->columnSpanFull(),
                TextInput::make('title_id')
                           ->label('Title (ID)')
                           ->required()
                           ->maxLength(255),
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description_id')
                    ->label('Description (ID)')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description_en')
                    ->label('Description (EN)')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('title_id')->label('Title (ID)'),
                Tables\Columns\TextColumn::make('description_id')->label('Description (ID)'),
            ])
            ->filters([
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false),
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
