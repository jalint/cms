<?php

namespace App\Filament\Resources\CustomerDistributionResource\Pages;

use App\Filament\Resources\CustomerDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerDistribution extends EditRecord
{
    protected static string $resource = CustomerDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\DeleteAction::make(),
        ];
    }
}
