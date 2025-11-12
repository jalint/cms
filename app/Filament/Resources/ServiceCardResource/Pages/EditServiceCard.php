<?php

namespace App\Filament\Resources\ServiceCardResource\Pages;

use App\Filament\Resources\ServiceCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditServiceCard extends EditRecord
{
    protected static string $resource = ServiceCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
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
