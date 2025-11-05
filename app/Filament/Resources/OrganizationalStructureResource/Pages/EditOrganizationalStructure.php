<?php

namespace App\Filament\Resources\OrganizationalStructureResource\Pages;

use App\Filament\Resources\OrganizationalStructureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditOrganizationalStructure extends EditRecord
{
    protected static string $resource = OrganizationalStructureResource::class;

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
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/struktur-organisasi&secret=JLIJayaSelalu');
    }
}
