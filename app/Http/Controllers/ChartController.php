<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChartController extends Controller
{
    public function index(Request $request)
    {
        // Get filter inputs for Barangay and Purok from the request
        $barangay = $request->input('barangay');
        $purok = $request->input('purok');
        $textFilter = '';

        if($barangay!='' && $purok!='') {
            $textFilter = "in {$barangay}, Purok {$purok}";
        }
        elseif($barangay != '') {
            $textFilter = "in {$barangay}";
        }
        elseif($purok != '') {
            $textFilter = "In All barangays in Purok {$purok}";
        } else {
            $textFilter = "in All Barangays";
        }

        // Color map for consistent chart colors
        $colorMap = [
            'plastic' => '#3498db', // Blue
            'paper' => '#2ecc71', // Green
            'metal' => '#e74c3c', // Red
            'glass' => '#f1c40f', // Yellow
            'electronics' => '#8e44ad', // Purple
        ];


        // Default color if a type/category is not in the map
        $defaultColor = '#000000'; // Black

        // 1. Total Waste Collected by Barangay with optional filtering
        $wasteByBarangayQuery = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->select(
                'dim_locations.barangay',
                DB::raw('SUM(fact_waste_collections.amount_collected) as total_waste')
            )
            ->groupBy('dim_locations.barangay');

        if ($barangay) {
            $wasteByBarangayQuery->where('dim_locations.barangay', $barangay);
        }
        if ($purok) {
            $wasteByBarangayQuery->where('dim_locations.purok', $purok);
        }

        $wasteByBarangay = $wasteByBarangayQuery->get();

        $barangayChart = (new LarapexChart)->barChart()
            ->setTitle("Total Recyclable Waste Collected {$textFilter}")
            ->setXAxis($wasteByBarangay->pluck('barangay')->toArray())
            ->setWidth(600)
            ->setHeight(300)
            ->addData('Waste Collected', $wasteByBarangay->pluck('total_waste')->toArray())
            ->setColors(array_values($colorMap));


        // 2. Waste Collection by Type and Category with optional filtering
        $wasteByTypeAndCategoryQuery = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->join('dim_wastes', 'fact_waste_collections.dim_waste_id', '=', 'dim_wastes.id')
            ->select(
                'dim_wastes.category_name',
                'dim_wastes.waste_name',
                DB::raw('SUM(fact_waste_collections.amount_collected) as total_waste')
            )
            ->groupBy('dim_wastes.category_name', 'dim_wastes.waste_name');

        if ($barangay) {
            $wasteByTypeAndCategoryQuery->where('dim_locations.barangay', $barangay);
        }
        if ($purok) {
            $wasteByTypeAndCategoryQuery->where('dim_locations.purok', $purok);
        }

        $wasteByTypeAndCategory = $wasteByTypeAndCategoryQuery->get();

        $totalWaste = $wasteByTypeAndCategory->sum('total_waste');

        $categories = $wasteByTypeAndCategory->pluck('category_name')->unique();
        $wasteTypes = $wasteByTypeAndCategory->pluck('waste_name')->unique();

        $typeCategoryChart = (new LarapexChart)->barChart()
            ->setTitle("Recyclable Waste Collection Data by Type and Category {$textFilter}")
            ->setWidth(600)
            ->setHeight(300)
            ->setXAxis($wasteTypes->toArray());

        // Prepare color mapping for each category
        $categoryColors = $categories->mapWithKeys(function ($category) use ($colorMap) {
            return [$category => $colorMap[$category] ?? '#000000']; // Default to black if no color exists
        })->toArray();

        foreach ($categories as $category) {
            $categoryData = $wasteByTypeAndCategory->where('category_name', $category);
            $amounts = $wasteTypes->map(function ($wasteType) use ($categoryData) {
                return $categoryData->firstWhere('waste_name', $wasteType)->total_waste ?? 0;
            });
            $typeCategoryChart->addData($category, $amounts->toArray());
        }

        // Apply colors for the categories
        $typeCategoryChart->setColors(array_values($categoryColors));


        // 3. Monthly Waste Collection Trend with optional filtering
        $monthlyWasteQuery = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->select(
                DB::raw("DATE_FORMAT(collection_date, '%Y-%m') as month"),
                DB::raw('SUM(amount_collected) as total_waste')
            )
            ->groupBy('month')
            ->orderBy('month');

        if ($barangay) {
            $monthlyWasteQuery->where('dim_locations.barangay', $barangay);
        }
        if ($purok) {
            $monthlyWasteQuery->where('dim_locations.purok', $purok);
        }

        $monthlyWaste = $monthlyWasteQuery->get();

        $monthlyTrendChart = (new LarapexChart)->areaChart()
            ->setTitle("Monthly Recyclable Waste Collection Trend {$textFilter}")
            ->setXAxis($monthlyWaste->pluck('month')->toArray())
            ->setWidth(1200)
            ->setHeight(250)
            ->addData('Waste Collected', $monthlyWaste->pluck('total_waste')->toArray());

        // 4. Estimated Weight of Waste by Category and Monthly (Line Chart with Multiple Lines)
        $estimatedWeightByCategoryLineQuery = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->join('dim_wastes', 'fact_waste_collections.dim_waste_id', '=', 'dim_wastes.id')
            ->select(
                'dim_wastes.category_name',
                DB::raw('SUM(fact_waste_collections.amount_collected * dim_wastes.est_weight) as total_est_weight'),
                DB::raw("DATE_FORMAT(fact_waste_collections.collection_date, '%Y-%m') as raw_month"), // Raw SQL date (e.g., 2024-01)
                DB::raw("MONTH(fact_waste_collections.collection_date) as month"), // Extract numerical month
                DB::raw("YEAR(fact_waste_collections.collection_date) as year")    // Extract year
            )
            ->groupBy('dim_wastes.category_name', 'raw_month', 'month', 'year')
            ->orderBy('year')
            ->orderBy('month');

        if ($barangay) {
            $estimatedWeightByCategoryLineQuery->where('dim_locations.barangay', $barangay);
        }
        if ($purok) {
            $estimatedWeightByCategoryLineQuery->where('dim_locations.purok', $purok);
        }

        $estimatedWeightByCategoryLine = $estimatedWeightByCategoryLineQuery->get();

        $categoryLines = $estimatedWeightByCategoryLine->groupBy('category_name');

        // Map numeric months (1-12) to their respective names
        $monthNames = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December',
        ];

        // Generate formatted x-axis labels (e.g., "January 2024")
        $formattedXAxis = $estimatedWeightByCategoryLine
            ->map(function ($item) use ($monthNames) {
                return $monthNames[$item->month] . ' ' . $item->year; // Convert month number to name + year
            })
            ->unique()
            ->values()
            ->toArray(); // Ensure x-axis labels are unique and in array format

        // Create Larapex Chart
        $lineChart = (new LarapexChart)->areaChart()
            ->setTitle("Estimated Kilo Weight of Waste by Category {$textFilter} (Monthly)")
            ->setWidth(1200)
            ->setHeight(300)
            ->setXAxis($formattedXAxis); // Use readable month-year format

        // Add data for each waste category
        foreach ($categoryLines as $category => $data) {
            $lineChart->addData($category, $data->pluck('total_est_weight')->toArray());
        }

        // Apply consistent colors for each category
        $lineChart->setColors(
            $categoryLines->keys()->map(fn($category) => $colorMap[$category] ?? $defaultColor)->toArray()
        );

        // 5. Estimated Weight by Barangay and Purok
        $estimatedWeightByBarangayAndPurokQuery = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->join('dim_wastes', 'fact_waste_collections.dim_waste_id', '=', 'dim_wastes.id')
            ->select(
                'dim_wastes.category_name',
                DB::raw('SUM(fact_waste_collections.amount_collected * dim_wastes.est_weight) as total_est_weight')
            );

        // Determine grouping and x-axis labels dynamically
        if ($barangay && $purok) {
            // Filter by specific barangay and purok, x-axis will show purok
            $xAxisColumn = 'dim_locations.purok';
            $estimatedWeightByBarangayAndPurokQuery->where('dim_locations.barangay', $barangay)
                ->where('dim_locations.purok', $purok);
        } elseif ($barangay) {
            // Filter by barangay, x-axis will show purok
            $xAxisColumn = 'dim_locations.purok';
            $estimatedWeightByBarangayAndPurokQuery->where('dim_locations.barangay', $barangay);
        } else {
            // No specific barangay, x-axis will show barangay names
            $xAxisColumn = 'dim_locations.barangay';
        }

        // Add x-axis column with proper labels (string for barangay, integer for purok)
        $estimatedWeightByBarangayAndPurokQuery->addSelect(DB::raw("$xAxisColumn as x_axis"))
            ->groupBy('dim_wastes.category_name', 'x_axis')
            ->orderBy('x_axis');

        // Fetch the data
        $estimatedWeightByBarangayAndPurok = $estimatedWeightByBarangayAndPurokQuery->get();

        //get all unique barangay value
        // Ensure unique x-axis values and sort them if needed
        $uniqueXAxisValues = $estimatedWeightByBarangayAndPurok
            ->pluck('x_axis') // Extract x_axis values
            ->unique()        // Remove duplicates
            ->sort()          // Sort values alphabetically or numerically
            ->values()        // Re-index the collection
            ->toArray();      // Convert to array


        // Group data by waste category
        $categoryLines1 = $estimatedWeightByBarangayAndPurok->groupBy('category_name');

        // Create Larapex Chart
        $weightChart = (new LarapexChart)->areaChart()
            ->setTitle("Estimated Kilo Weight of Waste by Category {$textFilter}")
            ->setWidth(1200)
            ->setHeight(300)
            ->setXAxis($uniqueXAxisValues);      // Convert to a plain array);

        // Add data for each waste category
        foreach ($categoryLines1 as $category => $data) {
            $weightChart->addData($category, $data->pluck('total_est_weight')->toArray());
        }

        // Apply consistent colors for each category
        $weightChart->setColors(
            $categoryLines1->keys()->map(fn($category) => $colorMap[$category])->toArray()
        );


        $barangays = DB::table('dim_locations')->distinct()->pluck('barangay');
        $puroks = DB::table('dim_locations')->distinct()->pluck('purok');

        $allData = DB::table('fact_waste_collections')
            ->join('dim_locations', 'fact_waste_collections.dim_location_id', '=', 'dim_locations.id')
            ->join('dim_wastes', 'fact_waste_collections.dim_waste_id', '=', 'dim_wastes.id')
            ->select(
                'fact_waste_collections.id',
                'fact_waste_collections.collection_date',
                'fact_waste_collections.amount_collected',
                'dim_locations.barangay',
                'dim_locations.purok',
                'dim_wastes.waste_name',
                'dim_wastes.category_name',
                'dim_wastes.est_weight',
                DB::raw('(fact_waste_collections.amount_collected * dim_wastes.est_weight) as calculated_est_weight')
            )
            ->get();

        return view('charts.index', [
            'barangayChart' => $barangayChart,
            'typeCategoryChart' => $typeCategoryChart,
            'monthlyTrendChart' => $monthlyTrendChart,
            'estimatedWeightLineChart' => $lineChart, // New line chart for estimated weight by category
            'barangays' => $barangays,
            'estimatedWeightByBarangayAndPurokChart' => $weightChart,
            'puroks' => $puroks,
            'selectedBarangay' => $barangay,
            'selectedPurok' => $purok,
            'totalWaste' => $totalWaste,
            'allData' => $allData,
            'textFilter' => $textFilter
        ]);
    }
}
