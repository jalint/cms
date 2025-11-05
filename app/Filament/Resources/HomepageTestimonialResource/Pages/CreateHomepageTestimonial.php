<?php

namespace App\Filament\Resources\HomepageTestimonialResource\Pages;

use App\Filament\Resources\HomepageTestimonialResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Http;

class CreateHomepageTestimonial extends CreateRecord
{
    protected static string $resource = HomepageTestimonialResource::class;

    protected function afterCreate(): void
    {
        Http::baseUrl(config('services.jalint.base_uri'))->get('/api/revalidate?path=/&secret=JLIJayaSelalu');
    }
}
