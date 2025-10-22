<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDistributionLegend extends Model
{
    protected $guarded = [];

    public function customerDistribution()
    {
        return $this->belongsTo(CustomerDistribution::class);
    }

    public function customerDistributionDatas()
    {
        return $this->hasMany(CustomerDistributionData::class);
    }
}
