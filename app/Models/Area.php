<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['city_id', 'name', 'is_active'];

    // Relationship with City
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function scopeIsActive($query)
    {
        return $query->where('is_active', 1);
    }
    public function logisticZoneAreas()
    {
        return $this->hasMany(LogisticZoneArea::class, 'area_id');
    }
}
    