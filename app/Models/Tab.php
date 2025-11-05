<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tab extends Model
{
    protected $guarded = [];

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class);
    }

    public function serviceCards()
    {
        return $this->hasMany(ServiceCard::class)->select(['id', 'title_id', 'title_en', 'slug_id', 'slug_en', 'background', 'tab_id'])->whereNull('parent_id');
    }
}
