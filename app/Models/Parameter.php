<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Parameter extends Model
{
    protected $guarded = [];

    public function parameterValues(): HasMany
    {
        return $this->hasMany(ParameterValue::class);
    }
}
