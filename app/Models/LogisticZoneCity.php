<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticZoneCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'logistic_id',
        'logistic_zone_id',
        'city_id',
    ];

    /**
     * Define the relationship with the Logistic model.
     */
    public function logistic()
    {
        return $this->belongsTo(Logistic::class);
    }

    /**
     * Define the relationship with the LogisticZone model.
     */
    public function logisticZone()
    {
        return $this->belongsTo(LogisticZone::class);
    }

    /**
     * Define the relationship with the City model.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
