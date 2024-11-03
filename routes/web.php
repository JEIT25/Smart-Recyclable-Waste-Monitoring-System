<?php

use App\Http\Controllers\ChartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index.homepage');
});

Route::get('/dashboard', [ChartController::class, 'index'])->name('charts.index');