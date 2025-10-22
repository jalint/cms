<?php

namespace App\Filament\Resources\HomepageServiceResource\Pages;

use App\Filament\Resources\HomepageServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHomepageServices extends ListRecords
{
    protected static string $resource = HomepageServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
