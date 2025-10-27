<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateGroup extends Model
{
    protected $guarded = [];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
