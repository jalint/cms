<?php

namespace App\Filament\Resources\CustomerDistributionResource\Pages;

use App\Filament\Resources\CustomerDistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerDistributions extends ListRecords
{
    protected static string $resource = CustomerDistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
