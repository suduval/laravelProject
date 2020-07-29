<?php

namespace App\Models;

use App\Traits\HasUUID;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasUUID;

    protected $table = 'properties';

    protected $uuidFieldName = 'guid';

    protected $guarded = [];

    public function analyticTypes(){
        return $this->belongsToMany(AnalyticType::class, 'property_analytics', 'property_id', 'analytic_type_id')->withTimestamps();
    }


}
