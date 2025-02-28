<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogisticZoneArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'logistic_id',
        'logistic_zone_id',
        'area_id',
    ];

    

    /**
     * Define the relationship with the Logistic model.
     */
    public function logistic()
    {
        return $this->belongsTo(Logistic::class, 'logistic_id');
    }

    /**
     * Define the relationship with the LogisticZone model.
     */
    public function logisticZone()
    {
        return $this->belongsTo(LogisticZone::class, 'logistic_zone_id');
    }

    /**
     * Define the relationship with the Area model.
     */
    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }
}
