<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\DimWasteController;
use App\Http\Controllers\FactWasteCollectionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Landing page route
Route::get('/', function () {
    return view('index.homepage',['isHomePage' => true]);
})->name('landing-page');

//authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//dashboard routes which shows the charts
Route::get('/dashboard', [ChartController::class, 'index'])->name('charts.index')->middleware('auth');

//fact waste collection routes
Route::resource('fact-waste-collections', FactWasteCollectionController::class)->only('create','store')->middleware('auth');

//adding new dim_waste ( waste name and category) routes
Route::resource('/waste-categories', DimWasteController::class)->only('store','create','destroy','edit','update')->middleware('auth');