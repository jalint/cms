<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $guarded = [];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
