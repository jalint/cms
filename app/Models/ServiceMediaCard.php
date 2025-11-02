<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceMediaCard extends Model
{
    protected $guarded = [];

    protected $table = 'service_media_cards';

    public function serviceCard()
    {
        return $this->hasMany(ServiceCard::class);
    }
}
