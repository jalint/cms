<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    protected $guarded = [];

    public function tabs()
    {
        return $this->hasMany(Tab::class);
    }
}
