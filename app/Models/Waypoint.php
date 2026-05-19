<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Waypoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'latitude',
        'longitude',
        'region',
        'type',
    ];

    protected $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * ATS routes that include this waypoint.
     */
    public function atsRoutes()
    {
        return $this->belongsToMany(ATSRoute::class, 'route_waypoint', 'waypoint_id', 'ats_route_id')
                    ->withPivot('sequence_order')
                    ->withTimestamps();
    }
}
