<?php

namespace App\Http\Controllers;

use App\Models\DimLocation;
use App\Models\DimWaste;
use App\Models\FactWasteCollection;
use Illuminate\Http\Request;

class FactWasteCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $allWasteAndCategory = DimWaste::all();

        return view('waste_collections.create',['allWasteAndCategory' => $allWasteAndCategory]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'city' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'purok' => 'required|integer|min:1',
            'dim_waste_id' => 'required|exists:dim_wastes,id',
            'amount_collected' => 'required|numeric|min:0',
            'collection_date' => 'required|date|before_or_equal:today',
        ]);

        // Query to find the dim_location ID
        $dimLocation = DimLocation::where('barangay', $validatedData['barangay'])
            ->where('purok', $validatedData['purok'])
            ->first();

        if (!$dimLocation) {
            return redirect()->back()
                ->withErrors(['dim_location' => 'The specified location does not exist.'])
                ->withInput();
        }

        // Creating the record
        $factWasteCollection = FactWasteCollection::create([
            'user_id' => $request->user()->id ?? 1,
            'dim_location_id' => $dimLocation->id,
            'dim_waste_id' => $validatedData['dim_waste_id'],
            'amount_collected' => $validatedData['amount_collected'],
            'collection_date' => $validatedData['collection_date'],
        ]);

        // Redirect with success message
        return redirect()
            ->route('charts.index')
            ->with('success', 'Waste collection record created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(FactWasteCollection $factWasteCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FactWasteCollection $factWasteCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FactWasteCollection $factWasteCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FactWasteCollection $factWasteCollection)
    {
        //
    }
}
