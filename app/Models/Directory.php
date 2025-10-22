<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Directory extends Model
{
    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];


    public function directoryDetails(): HasMany{
        return $this->hasMany(DirectoryDetail::class);
    }

}
