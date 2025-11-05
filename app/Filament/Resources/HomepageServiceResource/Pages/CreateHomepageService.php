<?php

namespace App\Filament\Resources\HomepageServiceResource\Pages;

use App\Filament\Resources\HomepageServiceResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateHomepageService extends CreateRecord
{
    protected static string $resource = HomepageServiceResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
