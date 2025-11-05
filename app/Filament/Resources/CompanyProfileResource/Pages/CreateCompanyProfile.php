<?php

namespace App\Filament\Resources\CompanyProfileResource\Pages;

use App\Filament\Resources\CompanyProfileResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateCompanyProfile extends CreateRecord
{
    protected static string $resource = CompanyProfileResource::class;

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/profil-perusahaan&secret=JLIJayaSelalu
');
    }
}
