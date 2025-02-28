<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LogisticZone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'logistic_id',
        'standard_delivery_charge',
        'standard_delivery_time',
        'express_delivery_charge',
        'express_delivery_time',
    ];

    public function logistic()
    {
        return $this->belongsTo(Logistic::class);
    }

    /**
     * Define the relationship with the LogisticZoneArea model.
     */
    public function areas()
    {
        return $this->hasMany(LogisticZoneArea::class, 'logistic_zone_id');
    }

    /**
     * Define the relationship with the LogisticZoneCity model.
     */
    public function cities()
    {
        return $this->hasMany(LogisticZoneCity::class, 'logistic_zone_id');
    }
}
