<?php

namespace App\Filament\Resources\HomepageCardResource\Pages;

use App\Filament\Resources\HomepageCardResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditHomepageCard extends EditRecord
{
    protected static string $resource = HomepageCardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()->after(function () {
                Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
            }),
        ];
    }

    protected function afterSave(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
