<?php

namespace App\Filament\Resources\HomepageServiceResource\Pages;

use App\Filament\Resources\HomepageServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHomepageService extends CreateRecord
{
    protected static string $resource = HomepageServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
