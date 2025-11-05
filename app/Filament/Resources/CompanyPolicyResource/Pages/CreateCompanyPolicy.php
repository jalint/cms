<?php

namespace App\Filament\Resources\CompanyPolicyResource\Pages;

use App\Filament\Resources\CompanyPolicyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateCompanyPolicy extends CreateRecord
{
    protected static string $resource = CompanyPolicyResource::class;

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/kebijakan-perusahaan&secret=JLIJayaSelalu');
    }
}
