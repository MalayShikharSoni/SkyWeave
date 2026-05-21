<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNavaidRequest;
use App\Http\Requests\UpdateNavaidRequest;
use App\Models\Navaid;
use Illuminate\Http\Request;

class NavaidController extends Controller
{
    /**
     * Display a listing of NAVAIDs with search and type filter.
     */
    public function index(Request $request)
    {
        $query = Navaid::query();

        // Search by identifier or name
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('identifier', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        // Filter by type
        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        $navaids = $query->orderBy('identifier')->paginate(15)->withQueryString();

        return view('navaids.index', compact('navaids'));
    }

    /**
     * Show the form for creating a new NAVAID.
     */
    public function create()
    {
        return view('navaids.create');
    }

    /**
     * Store a newly created NAVAID.
     */
    public function store(StoreNavaidRequest $request)
    {
        Navaid::create($request->validated());

        return redirect()
            ->route('navaids.index')
            ->with('success', 'NAVAID created successfully.');
    }

    /**
     * Show the form for editing a NAVAID.
     */
    public function edit(Navaid $navaid)
    {
        return view('navaids.edit', compact('navaid'));
    }

    /**
     * Update the specified NAVAID.
     */
    public function update(UpdateNavaidRequest $request, Navaid $navaid)
    {
        $navaid->update($request->validated());

        return redirect()
            ->route('navaids.index')
            ->with('success', 'NAVAID updated successfully.');
    }

    /**
     * Remove the specified NAVAID.
     */
    public function destroy(Navaid $navaid)
    {
        $navaid->delete();

        return redirect()
            ->route('navaids.index')
            ->with('success', 'NAVAID deleted successfully.');
    }
}
