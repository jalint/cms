<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPolicyDetail extends Model
{
    protected $guarded = [];

    public function companyPolicy()
    {
        return $this->belongsTo(CompanyPolicy::class);
    }
}
