<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWaypointRequest;
use App\Http\Requests\UpdateWaypointRequest;
use App\Models\Waypoint;
use Illuminate\Http\Request;

class WaypointController extends Controller
{
    /**
     * Display a listing of waypoints with search and filter.
     */
    public function index(Request $request)
    {
        $query = Waypoint::query();

        // Search by identifier or region
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('identifier', 'like', "%{$search}%")
                  ->orWhere('region', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $waypoints = $query->orderBy('identifier')->paginate(15)->withQueryString();

        return view('waypoints.index', compact('waypoints'));
    }

    /**
     * Show the form for creating a new waypoint.
     */
    public function create()
    {
        return view('waypoints.create');
    }

    /**
     * Store a newly created waypoint.
     */
    public function store(StoreWaypointRequest $request)
    {
        Waypoint::create($request->validated());

        return redirect()
            ->route('waypoints.index')
            ->with('success', 'Waypoint created successfully.');
    }

    /**
     * Show the form for editing a waypoint.
     */
    public function edit(Waypoint $waypoint)
    {
        return view('waypoints.edit', compact('waypoint'));
    }

    /**
     * Update the specified waypoint.
     */
    public function update(UpdateWaypointRequest $request, Waypoint $waypoint)
    {
        $waypoint->update($request->validated());

        return redirect()
            ->route('waypoints.index')
            ->with('success', 'Waypoint updated successfully.');
    }

    /**
     * Remove the specified waypoint.
     */
    public function destroy(Waypoint $waypoint)
    {
        $waypoint->delete();

        return redirect()
            ->route('waypoints.index')
            ->with('success', 'Waypoint deleted successfully.');
    }
}
