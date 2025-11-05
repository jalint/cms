<?php

namespace App\Filament\Resources\CompanyPolicyResource\Pages;

use App\Filament\Resources\CompanyPolicyResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditCompanyPolicy extends EditRecord
{
    protected static string $resource = CompanyPolicyResource::class;

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
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/kebijakan-perusahaan&secret=JLIJayaSelalu');
    }
}
