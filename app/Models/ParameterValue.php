<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ParameterValue extends Model
{
    protected $guarded = [];

    public function parameter(): BelongsTo
    {
        return $this->belongsTo(Parameter::class);
    }
}
