<?php

namespace App\Filament\Resources\CustomerDistributionResource\Pages;

use App\Filament\Resources\CustomerDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditCustomerDistribution extends EditRecord
{
    protected static string $resource = CustomerDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave()
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/tentang-kami/profil-perusahaan&secret=JLIJayaSelalu');
    }
}
