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
        <div class="chart-container">
            {!! $estimatedWeightLineChart->container() !!} <!-- New chart for estimated weight -->
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-container">
            {!! $estimatedWeightByBarangayAndPurokChart->container() !!} <!-- New chart for estimated weight -->
        </div>
    </div>

    <div class="charts-row">
        <div class="chart-container" id="monthlyChart">
            {!! $monthlyTrendChart->container() !!}
        </div>
    </div>

    <div class="charts-row table">
        <h1>Fact Waste Collection Data</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Collection Date</th>
                    <th>Amount Collected</th>
                    <th>Barangay</th>
                    <th>Purok</th>
                    <th>Waste Name</th>
                    <th>Category Name</th>
                    <th>Estimated Kilo Weight</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($allData as $data)
                    <tr>
                        <td>{{ $data->id }}</td>
                        <td>{{ $data->collection_date }}</td>
                        <td>{{ $data->amount_collected }}</td>
                        <td>{{ $data->barangay }}</td>
                        <td>{{ $data->purok }}</td>
                        <td>{{ $data->waste_name }}</td>
                        <td>{{ $data->category_name }}</td>
                        <td>{{ $data->calculated_est_weight }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    {{-- Included the LarapexCharts scripts --}}
@section('other-scripts')
    {{ $barangayChart->script() }}
    {{ $typeCategoryChart->script() }}
    {{ $monthlyTrendChart->script() }}
    {{ $estimatedWeightLineChart->script() }}
    {{ $estimatedWeightByBarangayAndPurokChart->script() }}
@endsection

@endsection
