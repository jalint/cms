<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDistribution extends Model
{
    protected $guarded = [];

    public function customerDistributionLegends()
    {
        return $this->hasMany(CustomerDistributionLegend::class);
    }

    public function customerDistributionDatas()
    {
        return $this->hasManyThrough(
            CustomerDistributionData::class,        // Model tujuan
            CustomerDistributionLegend::class,      // Model perantara
            'customer_distribution_id',              // FK di tabel legends
            'customer_distribution_legend_id',       // FK di tabel datas
            'id',                                    // PK di tabel distributions
            'id'                                     // PK di tabel legends
        );
    }
}
