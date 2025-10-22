<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocument extends Model
{
    protected $guarded = [];

    public function legalDocumentDetails()
    {
        return $this->hasMany(LegalDocumentDetail::class);
    }
}
