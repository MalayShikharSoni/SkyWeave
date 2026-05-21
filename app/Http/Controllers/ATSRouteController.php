<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreATSRouteRequest;
use App\Http\Requests\UpdateATSRouteRequest;
use App\Models\ATSRoute;
use App\Models\Waypoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ATSRouteController extends Controller
{
    /**
     * Display a listing of ATS routes.
     */
    public function index(Request $request)
    {
        $query = ATSRoute::with(['creator', 'waypoints']);

        // Search by route name
        if ($search = $request->input('search')) {
            $query->where('route_name', 'like', "%{$search}%");
        }

        $routes = $query->orderBy('route_name')->paginate(15)->withQueryString();

        return view('routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new ATS route.
     */
    public function create()
    {
        $waypoints = Waypoint::orderBy('identifier')->get();
        return view('routes.create', compact('waypoints'));
    }

    /**
     * Store a newly created ATS route.
     */
    public function store(StoreATSRouteRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $route = ATSRoute::create([
                'route_name'  => $request->route_name,
                'description' => $request->description,
                'created_by'  => Auth::id(),
            ]);

            // Attach waypoints with sequence order
            $waypointIds = $request->waypoints;
            $syncData = [];
            foreach ($waypointIds as $index => $waypointId) {
                $syncData[$waypointId] = ['sequence_order' => $index + 1];
            }
            $route->waypoints()->sync($syncData);

            // Clear draft from session
            session()->forget('draft_route');

            return redirect()
                ->route('routes.show', $route)
                ->with('success', 'ATS route created successfully.');
        });
    }

    /**
     * Display the specified ATS route.
     */
    public function show(ATSRoute $route)
    {
        $route->load(['creator', 'waypoints']);
        $distance = $route->calculateDistance();

        return view('routes.show', compact('route', 'distance'));
    }

    /**
     * Show the form for editing an ATS route.
     */
    public function edit(ATSRoute $route)
    {
        $route->load('waypoints');
        $waypoints = Waypoint::orderBy('identifier')->get();

        return view('routes.edit', compact('route', 'waypoints'));
    }

    /**
     * Update the specified ATS route.
     */
    public function update(UpdateATSRouteRequest $request, ATSRoute $route)
    {
        return DB::transaction(function () use ($request, $route) {
            $route->update([
                'route_name'  => $request->route_name,
                'description' => $request->description,
            ]);

            // Sync waypoints with new sequence order
            $waypointIds = $request->waypoints;
            $syncData = [];
            foreach ($waypointIds as $index => $waypointId) {
                $syncData[$waypointId] = ['sequence_order' => $index + 1];
            }
            $route->waypoints()->sync($syncData);

            return redirect()
                ->route('routes.show', $route)
                ->with('success', 'ATS route updated successfully.');
        });
    }

    /**
     * Remove the specified ATS route.
     */
    public function destroy(ATSRoute $route)
    {
        $route->delete();

        return redirect()
            ->route('routes.index')
            ->with('success', 'ATS route deleted successfully.');
    }
}
