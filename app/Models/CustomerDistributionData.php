<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDistributionData extends Model
{
    protected $guarded = [];

    protected $table = 'customer_distribution_datas';

    public function customerDistributionLegend()
    {
        return $this->belongsTo(CustomerDistributionLegend::class);
    }
}
