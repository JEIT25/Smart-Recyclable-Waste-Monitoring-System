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

        // 1. Total Waste Collected by Barangay with optional filtering
        $wasteByBarangayQuery = DB::table('fact_waste_collection')
            ->join('dim_location', 'fact_waste_collection.dim_location_id', '=', 'dim_location.id')
            ->select(
                'dim_location.barangay',
                DB::raw('SUM(fact_waste_collection.amount_collected) as total_waste')
            )
            ->groupBy('dim_location.barangay');

        if ($barangay) {
            $wasteByBarangayQuery->where('dim_location.barangay', $barangay);
        }
        if ($purok) {
            $wasteByBarangayQuery->where('dim_location.purok', $purok);
        }

        $wasteByBarangay = $wasteByBarangayQuery->get();

        $barangayChart = (new LarapexChart)->barChart()
            ->setTitle('Total Recyclable Waste Collected by Barangay')
            ->setXAxis($wasteByBarangay->pluck('barangay')->toArray())
            ->setWidth(600)
            ->setHeight(300)
            ->addData('Waste Collected', $wasteByBarangay->pluck('total_waste')->toArray());

        // 2. Waste Collection by Type and Category with optional filtering
        $wasteByTypeAndCategoryQuery = DB::table('fact_waste_collection')
            ->join('dim_location', 'fact_waste_collection.dim_location_id', '=', 'dim_location.id')
            ->join('dim_waste', 'fact_waste_collection.dim_waste_id', '=', 'dim_waste.id')
            ->select(
                'dim_waste.category_name',
                'dim_waste.waste_name',
                DB::raw('SUM(fact_waste_collection.amount_collected) as total_waste')
            )
            ->groupBy('dim_waste.category_name', 'dim_waste.waste_name');

        if ($barangay) {
            $wasteByTypeAndCategoryQuery->where('dim_location.barangay', $barangay);
        }
        if ($purok) {
            $wasteByTypeAndCategoryQuery->where('dim_location.purok', $purok);
        }

        $wasteByTypeAndCategory = $wasteByTypeAndCategoryQuery->get();

        $totalWaste = $wasteByTypeAndCategory->sum('total_waste');

        $categories = $wasteByTypeAndCategory->pluck('category_name')->unique();
        $wasteTypes = $wasteByTypeAndCategory->pluck('waste_name')->unique();

        $typeCategoryChart = (new LarapexChart)->barChart()
            ->setTitle('Recyclable Waste Collection by Type and Category')
            ->setWidth(600)
            ->setHeight(300)
            ->setXAxis($wasteTypes->toArray());

        foreach ($categories as $category) {
            $categoryData = $wasteByTypeAndCategory->where('category_name', $category);
            $amounts = $wasteTypes->map(function ($wasteType) use ($categoryData) {
                return $categoryData->firstWhere('waste_name', $wasteType)->total_waste ?? 0;
            });
            $typeCategoryChart->addData($category, $amounts->toArray());
        }

        // 3. Monthly Waste Collection Trend with optional filtering
        $monthlyWasteQuery = DB::table('fact_waste_collection')
            ->join('dim_location', 'fact_waste_collection.dim_location_id', '=', 'dim_location.id')
            ->select(
                DB::raw("DATE_FORMAT(collection_date, '%Y-%m') as month"),
                DB::raw('SUM(amount_collected) as total_waste')
            )
            ->groupBy('month')
            ->orderBy('month');

        if ($barangay) {
            $monthlyWasteQuery->where('dim_location.barangay', $barangay);
        }
        if ($purok) {
            $monthlyWasteQuery->where('dim_location.purok', $purok);
        }

        $monthlyWaste = $monthlyWasteQuery->get();

        $monthlyTrendChart = (new LarapexChart)->lineChart()
            ->setTitle('Monthly Recyclable Waste Collection Trend')
            ->setXAxis($monthlyWaste->pluck('month')->toArray())
            ->setWidth(1200)
            ->setHeight(250)
            ->addData('Waste Collected', $monthlyWaste->pluck('total_waste')->toArray());

        // Passing all charts and filtering options to the view
        $barangays = DB::table('dim_location')->distinct()->pluck('barangay');
        $puroks = DB::table('dim_location')->distinct()->pluck('purok');

        return view('charts.index', [
            'barangayChart' => $barangayChart,
            'typeCategoryChart' => $typeCategoryChart,
            'monthlyTrendChart' => $monthlyTrendChart,
            'barangays' => $barangays,
            'puroks' => $puroks,
            'selectedBarangay' => $barangay,
            'selectedPurok' => $purok,
            'totalWaste' => $totalWaste
        ]);
    }
}