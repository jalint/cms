<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $guarded = [];

    public function corporateGroups()
    {
        return $this->hasMany(CorporateGroup::class);
    }
}
