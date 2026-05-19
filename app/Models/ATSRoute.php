<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ATSRoute extends Model
{
    use HasFactory;

    protected $table = 'ats_routes';

    protected $fillable = [
        'route_name',
        'description',
        'created_by',
    ];

    /**
     * User who created this route.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Ordered waypoints in this route.
     */
    public function waypoints()
    {
        return $this->belongsToMany(Waypoint::class, 'route_waypoint', 'ats_route_id', 'waypoint_id')
                    ->withPivot('sequence_order')
                    ->orderByPivot('sequence_order')
                    ->withTimestamps();
    }

    /**
     * Calculate total route distance in nautical miles.
     */
    public function calculateDistance(): float
    {
        $waypoints = $this->waypoints;
        $totalDistance = 0;

        for ($i = 0; $i < $waypoints->count() - 1; $i++) {
            $totalDistance += $this->haversineDistance(
                $waypoints[$i]->latitude,
                $waypoints[$i]->longitude,
                $waypoints[$i + 1]->latitude,
                $waypoints[$i + 1]->longitude
            );
        }

        return round($totalDistance, 2);
    }

    /**
     * Haversine formula — returns distance in nautical miles.
     */
    private function haversineDistance(float $lat1, float $lon1, float $lat2, float $lon2): float
    {
        $earthRadiusNm = 3440.065; // Earth radius in nautical miles

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadiusNm * $c;
    }
}
