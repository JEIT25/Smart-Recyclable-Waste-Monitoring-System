@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/pages/waste_category/create.css') }}">
@endsection

@section('page-title', 'Manage Dim Waste')
@section('main-content')
    <div class="container">
        <div class="row">
            <!-- Image Section (Left side) -->
            <div class="col-md-6">
                <div class="image-section">
                    <img src="{{ asset('images/covers/waste_cover.png') }}" alt="Waste Category Image" class="img-fluid">
                </div>
            </div>

            <!-- Form Section (Right side) -->
            <div class="col-md-6">
                <div class="form-section">
                    <h1 class="form-title">Add New Waste</h1>
                    <form action="{{ route('waste-categories.store') }}" method="POST" class="modern-form">
                        @csrf
                        <!-- Waste Name -->
                        <div class="form-group">
                            <label for="waste_name">Waste Name</label>
                            <input type="text" id="waste_name" name="waste_name" placeholder="Enter waste name"
                                value="{{ old('waste_name') }}">
                            @error('waste_name')
                                <div class="error-message" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Category -->
                        <div class="form-group">
                            <label for="category_name">Category</label>
                            <select id="category_name" name="category_name">
                                <option value="" disabled {{ old('category_name') == '' ? 'selected' : '' }}>
                                    Select Category
                                </option>
                                <option value="plastic" {{ old('category_name') == 'plastic' ? 'selected' : '' }}>
                                    Plastic
                                </option>
                                <option value="paper" {{ old('category_name') == 'paper' ? 'selected' : '' }}>
                                    Paper
                                </option>
                                <option value="glass" {{ old('category_name') == 'glass' ? 'selected' : '' }}>
                                    Glass
                                </option>
                                <option value="metal" {{ old('category_name') == 'metal' ? 'selected' : '' }}>
                                    Metal
                                </option>
                                <option value="electronics" {{ old('category_name') == 'electronics' ? 'selected' : '' }}>
                                    Electronics
                                </option>
                            </select>
                            @error('category_name')
                                <div class="error-message" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estimated Weight -->
                        <div class="form-group">
                            <label for="est_weight">Estimated Weight (kg)</label>
                            <input type="number" id="est_weight" name="est_weight" placeholder="Enter weight" step="0.01"
                                value="{{ old('est_weight') }}">
                            @error('est_weight')
                                <div class="error-message" style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group text-center">
                            <button type="submit" class="btn-submit">Add Waste</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Table Section -->
        <div class="table-section">
            <h2 class="table-title">Registered Recyclable Waste and Category</h2>
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>Waste Name</th>
                        <th>Category</th>
                        <th>Estimated Weight (kg)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allWasteAndCategory as $waste)
                        <tr>
                            <td>{{ $waste->waste_name }}</td>
                            <td>{{ ucfirst($waste->category_name) }}</td>
                            <td>{{ number_format($waste->est_weight, 2) }}</td>
                            <td>
                                <!-- Edit Button -->
                                <a href="{{ route('waste-categories.edit', $waste->id) }}" class="action-button action-edit">Edit</a>

                                <!-- Delete Button (Form for CSRF Protection) -->
                                <form action="{{ route('waste-categories.destroy', $waste->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-button action-delete" onclick="return confirm('Are you sure you want to delete this item?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
