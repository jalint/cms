<?php

namespace App\Filament\Resources\HomepageCardResource\Pages;

use App\Filament\Resources\HomepageCardResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateHomepageCard extends CreateRecord
{
    protected static string $resource = HomepageCardResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
