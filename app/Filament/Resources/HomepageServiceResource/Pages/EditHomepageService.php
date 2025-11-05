<?php

namespace App\Filament\Resources\HomepageServiceResource\Pages;

use App\Filament\Resources\HomepageServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditHomepageService extends EditRecord
{
    protected static string $resource = HomepageServiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
