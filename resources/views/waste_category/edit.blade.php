@extends('layouts.app')

@section('css')
 <link rel="stylesheet" href="{{asset('css/pages/waste_category/edit.css')}}">
@endsection

@section('page-title', 'Edit Waste Category')

@section('main-content')
    <div class="container">
        <div class="form-section">
            <h1 class="form-title">Edit Waste Category</h1>
            <form action="{{ route('waste-categories.update', $waste->id) }}" method="POST" class="modern-form">
                @csrf
                @method('PUT')
                <!-- Waste Name -->
                <div class="form-group">
                    <label for="waste_name">Waste Name</label>
                    <input type="text" id="waste_name" name="waste_name" placeholder="Enter waste name"
                           value="{{ old('waste_name', $waste->waste_name) }}">
                    @error('waste_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Category -->
                <div class="form-group">
                    <label for="category_name">Category</label>
                    <select id="category_name" name="category_name">
                        <option value="plastic" {{ old('category_name', $waste->category_name) == 'plastic' ? 'selected' : '' }}>Plastic</option>
                        <option value="paper" {{ old('category_name', $waste->category_name) == 'paper' ? 'selected' : '' }}>Paper</option>
                        <option value="glass" {{ old('category_name', $waste->category_name) == 'glass' ? 'selected' : '' }}>Glass</option>
                        <option value="metal" {{ old('category_name', $waste->category_name) == 'metal' ? 'selected' : '' }}>Metal</option>
                        <option value="electronics" {{ old('category_name', $waste->category_name) == 'electronics' ? 'selected' : '' }}>Electronics</option>
                    </select>
                    @error('category_name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Estimated Weight -->
                <div class="form-group">
                    <label for="est_weight">Estimated Weight (kg)</label>
                    <input type="number" id="est_weight" name="est_weight" placeholder="Enter weight" step="0.01"
                           value="{{ old('est_weight', $waste->est_weight) }}">
                    @error('est_weight')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="form-group text-center">
                    <button type="submit" class="btn-submit">Update Waste</button>
                </div>
            </form>
        </div>
    </div>
@endsection