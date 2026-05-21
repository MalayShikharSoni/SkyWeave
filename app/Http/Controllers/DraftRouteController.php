<?php

namespace App\Http\Controllers;

use App\Models\Waypoint;
use Illuminate\Http\Request;

class DraftRouteController extends Controller
{
    /**
     * Add a waypoint to the session draft route.
     */
    public function addWaypoint(Request $request)
    {
        $request->validate([
            'waypoint_id' => ['required', 'integer', 'exists:waypoints,id'],
        ]);

        $draft = session('draft_route.waypoints', []);

        // Prevent duplicates
        if (!in_array($request->waypoint_id, $draft)) {
            $draft[] = (int) $request->waypoint_id;
        }

        session(['draft_route.waypoints' => $draft]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'   => true,
                'waypoints' => $this->getDraftWaypoints($draft),
            ]);
        }

        return back()->with('success', 'Waypoint added to draft.');
    }

    /**
     * Remove a waypoint from the session draft route.
     */
    public function removeWaypoint(Request $request)
    {
        $request->validate([
            'waypoint_id' => ['required', 'integer'],
        ]);

        $draft = session('draft_route.waypoints', []);
        $draft = array_values(array_filter($draft, fn($id) => $id !== (int) $request->waypoint_id));

        session(['draft_route.waypoints' => $draft]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'   => true,
                'waypoints' => $this->getDraftWaypoints($draft),
            ]);
        }

        return back()->with('success', 'Waypoint removed from draft.');
    }

    /**
     * Clear the entire draft route.
     */
    public function clearDraft(Request $request)
    {
        session()->forget('draft_route');

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'waypoints' => []]);
        }

        return back()->with('success', 'Draft route cleared.');
    }

    /**
     * Get the current draft route state (JSON).
     */
    public function getDraft(Request $request)
    {
        $draft = session('draft_route.waypoints', []);

        return response()->json([
            'waypoints' => $this->getDraftWaypoints($draft),
        ]);
    }

    /**
     * Reorder waypoints in the draft.
     */
    public function reorderWaypoints(Request $request)
    {
        $request->validate([
            'waypoints'   => ['required', 'array'],
            'waypoints.*' => ['required', 'integer'],
        ]);

        session(['draft_route.waypoints' => $request->waypoints]);

        if ($request->expectsJson()) {
            return response()->json([
                'success'   => true,
                'waypoints' => $this->getDraftWaypoints($request->waypoints),
            ]);
        }

        return back();
    }

    /**
     * Helper: Hydrate waypoint IDs into full models.
     */
    private function getDraftWaypoints(array $ids): array
    {
        if (empty($ids)) {
            return [];
        }

        $waypoints = Waypoint::whereIn('id', $ids)->get()->keyBy('id');

        // Preserve order
        return collect($ids)
            ->map(fn($id) => $waypoints->get($id))
            ->filter()
            ->values()
            ->toArray();
    }
}
