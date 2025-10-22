<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LegalDocumentDetail extends Model
{
    protected $guarded = [];

    public function legalDocument()
    {
        return $this->belongsTo(LegalDocument::class);
    }
}
