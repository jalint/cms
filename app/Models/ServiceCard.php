<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceCard extends Model
{
    protected $guarded = [];

    public function serviceMediaCards()
    {
        return $this->hasMany(ServiceMediaCard::class);
    }

    public function tab()
    {
        return $this->belongsTo(Tab::class);
    }

    public function parentSelect()
    {
        return $this->belongsTo(ServiceCard::class, 'parent_id')->whereNull('parent_id');
    }

    public function parent()
    {
        return $this->belongsTo(ServiceCard::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(ServiceCard::class, 'parent_id');
    }
}
