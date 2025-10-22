<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HomepageService extends Model
{
    //
    protected $guarded = [];

       protected $casts = [
        'is_active' => 'boolean',
    ];


    public function homepagecards(): HasMany{
        return $this->hasMany(HomepageCard::class);
    }
}
