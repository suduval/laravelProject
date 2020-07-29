<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnalyticType extends Model
{
    protected $table = 'analytic_types';

    protected $guarded = [];

    public function properties(){
        return $this->belongsToMany(Property::class, 'property_analytics', 'analytic_type_id', 'property_id')->withTimestamps();
    }
}
