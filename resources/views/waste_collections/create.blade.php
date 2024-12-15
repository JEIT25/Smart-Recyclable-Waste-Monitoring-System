@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/waste_collections/create.css') }}">
@endsection

@section('page-title', 'Add Waste Collection')
@section('main-content')
    <div class="container">
        <div class="form-container">
            <!-- Left Image -->
            <div class="image-section">
                <img src="{{ asset('images/covers/collection_cover.png') }}" alt="Waste Collection" />
            </div>

            <!-- Right Form -->
            <div class="form-section">
                <h1>Waste Collection Form</h1>
                <form action="{{ route('fact-waste-collections.store') }}" method="POST">
                    @csrf

                    <!-- City Field (Read-Only) -->
                    <div class="form-group">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" value="Cabadbaran" readonly />
                    </div>

                    <!-- Barangay Select -->
                    <div class="form-group">
                        <label for="barangay">Barangay</label>
                        <select id="barangay" name="barangay">
                            <option value="" disabled {{ old('barangay') ? '' : 'selected' }}>Select Barangay</option>
                            @foreach (['Antonio Luna', 'Bay-ang', 'Bayabas', 'Caasinan', 'Cabinet', 'Calamba', 'Calibunan', 'Comagascas', 'Concepcion', 'Del Pilar', 'Katugasan', 'Kauswagan', 'La Union', 'Mabini', 'Poblacion 1', 'Poblacion 2', 'Poblacion 3', 'Poblacion 4', 'Poblacion 5', 'Poblacion 6', 'Poblacion 7', 'Poblacion 8', 'Poblacion 9', 'Poblacion 10', 'Poblacion 11', 'Poblacion 12', 'Puting Bato', 'Sanghan', 'Soriano', 'Tolosa', 'Mahaba'] as $barangay)
                                <option value="{{ $barangay }}" {{ old('barangay') == $barangay ? 'selected' : '' }}>
                                    {{ $barangay }}
                                </option>
                            @endforeach
                        </select>
                        @error('barangay')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Purok Select -->
                    <div class="form-group">
                        <label for="purok">Purok</label>
                        <select id="purok" name="purok">
                            <option value="" disabled {{ old('purok') ? '' : 'selected' }}>Select Purok</option>
                            @for ($i = 1; $i <= 10; $i++)
                                <option value="{{ $i }}" {{ old('purok') == $i ? 'selected' : '' }}>
                                    Purok {{ $i }}
                                </option>
                            @endfor
                        </select>
                        @error('purok')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Waste Name Select -->
                    <div class="form-group">
                        <label for="waste_name">Waste Name & Category</label>
                        <select id="waste_name" name="dim_waste_id">
                            <option value="" disabled {{ old('dim_waste_id') ? '' : 'selected' }}>Select Waste & Category</option>
                            @foreach ($allWasteAndCategory as $waste)
                                <option value="{{ $waste->id }}" {{ old('dim_waste_id') == $waste->id ? 'selected' : '' }}>
                                    {{ $waste->waste_name }} - {{ $waste->category_name }} category
                                </option>
                            @endforeach
                        </select>
                        @error('dim_waste_id')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Amount Collected -->
                    <div class="form-group">
                        <label for="amount_collected">Amount Collected</label>
                        <input type="number" id="amount_collected" name="amount_collected" placeholder="Enter amount"
                            value="{{ old('amount_collected') }}" />
                        @error('amount_collected')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Collection Date -->
                    <div class="form-group">
                        <label for="collection_date">Collection Date</label>
                        <input type="date" id="collection_date" name="collection_date"
                            value="{{ old('collection_date') }}" />
                        @error('collection_date')
                            <small class="error-message">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Submit Button -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn-submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection