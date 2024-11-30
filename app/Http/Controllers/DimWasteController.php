<?php

namespace App\Http\Controllers;

use App\Models\DimWaste;
use Illuminate\Http\Request;

class DimWasteController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all waste categories for displaying in the form (if necessary)
        $allWasteAndCategory = DimWaste::all();

        return view('waste_category.create', ['allWasteAndCategory' => $allWasteAndCategory]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation
        $validatedData = $request->validate([
            'waste_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'est_weight' => 'required|numeric|min:0.01',
        ]);

        // Create new dim_waste record
        DimWaste::create([
            'waste_name' => $validatedData['waste_name'],
            'category_name' => $validatedData['category_name'],
            'est_weight' => $validatedData['est_weight'],
        ]);

        // Redirect with success message
        return redirect()
            ->route('charts.index')  // or any other route you wish
            ->with('success', 'Waste category created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(DimWaste $dimWaste)
    {
        // Display the details of the specific waste category if needed
        return view('waste_category.show', compact('dimWaste'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($dimWaste)
    {
        // Find the waste by its ID
        $waste = DimWaste::find($dimWaste);

        // Check if the record exists
        if (!$waste) {
            return redirect()
                ->route('waste-categories.create')
                ->with('error', 'Waste category not found.');
        }

        // Pass the data to the edit view
        return view('waste_category.edit', ['waste' => $waste]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $dimWaste)
    {
        // Validation
        $validatedData = $request->validate([
            'waste_name' => 'required|string|max:255',
            'category_name' => 'required|string|max:255',
            'est_weight' => 'required|numeric|min:0.01',
        ]);

        // Find the record by ID
        $waste = DimWaste::find($dimWaste);

        // Check if the record exists
        if (!$waste) {
            return redirect()
                ->route('waste-categories.create')
                ->with('error', 'Waste category not found.');
        }

        // Update the record
        $waste->update([
            'waste_name' => $validatedData['waste_name'],
            'category_name' => $validatedData['category_name'],
            'est_weight' => $validatedData['est_weight'],
        ]);

        // Redirect with success message
        return redirect()
            ->route('waste-categories.create')  // or your desired route
            ->with('success', 'Waste category updated successfully!');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($dimWaste)
    {

        // Delete the specified waste category
        DimWaste::destroy($dimWaste); // Deletes the record with the given ID

        // Redirect with success message
        return redirect()
            ->route('waste-categories.create')  // or the appropriate route
            ->with('success', 'Waste category deleted successfully!');
    }
}
