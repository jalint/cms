<?php

namespace App\Filament\Resources\HomepageServiceResource\Pages;

use App\Filament\Resources\HomepageServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomepageService extends EditRecord
{
    protected static string $resource = HomepageServiceResource::class;

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
}
