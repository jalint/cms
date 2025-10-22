<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MilestoneDetail extends Model
{
    protected $guarded = [];

    public function milestone(): BelongsTo
    {
        return $this->belongsTo(Milestone::class);
    }
}
