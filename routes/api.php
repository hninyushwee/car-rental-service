<?php

use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\DriverController;
use App\Http\Controllers\Api\VehicleController;
use App\Http\Controllers\Auth\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register'])->name('api.register');
Route::post('/login', [AuthApiController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/categories', [CategoryController::class, 'index'])->name('api.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('api.categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('api.categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('api.categories.destroy');

    Route::get('/brands', [BrandController::class, 'index'])->name('api.brands.index');
    Route::post('/brands', [BrandController::class, 'store'])->name('api.brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('api.brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('api.brands.destroy');

    Route::get('/vehicles', [VehicleController::class, 'index'])->name('api.vehicles.index');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('api.vehicles.store');
    Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('api.vehicles.show');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('api.vehicles.update');
    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('api.vehicles.destroy');

    Route::get('/drivers', [DriverController::class, 'index'])->name('api.drivers.index');
    Route::post('/drivers', [DriverController::class, 'store'])->name('api.drivers.store');
    Route::get('/drivers/{driver}', [DriverController::class, 'show'])->name('api.drivers.show');
    Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('api.drivers.update');
    Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('api.drivers.destroy');
});

Route::middleware('auth:sanctum')->post('/logout', [AuthApiController::class, 'logout'])->name('logout');
