<?php

namespace App\Filament\Resources\HomepageTestimonialResource\Pages;

use App\Filament\Resources\HomepageTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Http;

class EditHomepageTestimonial extends EditRecord
{
    protected static string $resource = HomepageTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
