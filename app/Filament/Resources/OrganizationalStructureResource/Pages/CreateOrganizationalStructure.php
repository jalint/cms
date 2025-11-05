<?php

namespace App\Filament\Resources\OrganizationalStructureResource\Pages;

use App\Filament\Resources\OrganizationalStructureResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateOrganizationalStructure extends CreateRecord
{
    protected static string $resource = OrganizationalStructureResource::class;

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/struktur-organisasi&secret=JLIJayaSelalu');
    }
}
