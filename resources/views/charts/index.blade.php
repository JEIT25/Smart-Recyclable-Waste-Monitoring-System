{{-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waste Collection Chart</title>

    <!-- Include the ApexCharts CDN script -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <!-- Include Vite script to load your app.js -->
    @vite(['resources/js/app.js'])
</head>
<body>
@foreach ($charts as $barangay => $chart)
    <h2>{{ $barangay }}</h2>
    {!! $chart->container() !!}
@endforeach

<script src="{{ LarapexChart::cdn() }}"></script>
@foreach ($charts as $chart)
    {{ $chart->script() }}
@endforeach

</body>
</html> --}}

@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/charts/index.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('js/apexcharts.js') }}"></script>
@endsection


@section('page-title', 'Dashboard')

@section('main-content')
    <form method="GET" action="{{ route('charts.index') }}" id="filterForm">
        <div class="custom-select">
            <select name="barangay" id="barangay" class="custom-select">
                <option value="">Select Barangay</option>
                @foreach ($barangays as $barangayOption)
                    <option value="{{ $barangayOption }}" {{ $selectedBarangay == $barangayOption ? 'selected' : '' }}>
                        {{ $barangayOption }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="custom-select">
            <select name="purok" id="purok">
                <option value="">Select Purok</option>
                @foreach ($puroks as $purokOption)
                    <option value="{{ $purokOption }}" {{ $selectedPurok == $purokOption ? 'selected' : '' }}>
                        {{ $purokOption }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" id="submitBtn">Filter</button>


        <div class="totalWaste">
            <h3>
                Collected Recyclable Waste : <u>{{ number_format($totalWaste, 0) }}</u>
            </h3>
        </div>
    </form>

    <div class="charts-row">
        <div class="chart-container" id="typeChart">
            {!! $typeCategoryChart->container() !!}
        </div>
        <div class="chart-container" id="barangayChart">
            {!! $barangayChart->container() !!}
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-container" id="monthlyChart">
            {!! $monthlyTrendChart->container() !!}
        </div>
    </div>


    {{-- Included the LarapexCharts scripts --}}
@section('other-scripts')
    {{ $barangayChart->script() }}
    {{ $typeCategoryChart->script() }}
    {{ $monthlyTrendChart->script() }}
@endsection

@endsection
