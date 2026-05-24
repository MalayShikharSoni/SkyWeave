<?php

namespace App\Http\Controllers;

use App\Models\ATSRoute;
use App\Models\Navaid;
use App\Models\Waypoint;
use Illuminate\Http\JsonResponse;

class MapApiController extends Controller
{
    /**
     * Return all waypoints as JSON for map rendering.
     */
    public function waypoints(): JsonResponse
    {
        $waypoints = Waypoint::select('id', 'identifier', 'latitude', 'longitude', 'type', 'region')
            ->orderBy('identifier')
            ->get();

        return response()->json($waypoints);
    }

    /**
     * Return all NAVAIDs as JSON for map rendering.
     */
    public function navaids(): JsonResponse
    {
        $navaids = Navaid::select('id', 'identifier', 'name', 'type', 'frequency', 'latitude', 'longitude')
            ->orderBy('identifier')
            ->get();

        return response()->json($navaids);
    }

    /**
     * Return all ATS routes with ordered waypoints as JSON for map rendering.
     */
    public function routes(): JsonResponse
    {
        $routes = ATSRoute::with(['waypoints' => function ($query) {
            $query->select('waypoints.id', 'identifier', 'latitude', 'longitude', 'type')
                  ->orderByPivot('sequence_order');
        }])
        ->select('id', 'route_name', 'description')
        ->orderBy('route_name')
        ->get();

        return response()->json($routes);
    }
}
