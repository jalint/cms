<?php

namespace App\Filament\Resources\DirectoryResource\Pages;

use App\Filament\Resources\DirectoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateDirectory extends CreateRecord
{
    protected static string $resource = DirectoryResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
