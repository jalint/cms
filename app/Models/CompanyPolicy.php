<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyPolicy extends Model
{
    protected $guarded = [];

    /**
     * Get the company policy details related to this policy.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\CompanyPolicyDetail>
     */
    public function companyPolicyDetails()
    {
        return $this->hasMany(CompanyPolicyDetail::class);
    }
}
