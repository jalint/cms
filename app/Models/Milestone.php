<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Milestone extends Model
{
    protected $guarded = [];

    public function milestoneDetails(): HasMany
    {
        return $this->hasMany(MilestoneDetail::class);
    }
}
