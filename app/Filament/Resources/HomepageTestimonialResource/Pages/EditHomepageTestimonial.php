<?php

namespace App\Filament\Resources\HomepageTestimonialResource\Pages;

use App\Filament\Resources\HomepageTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHomepageTestimonial extends EditRecord
{
    protected static string $resource = HomepageTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
