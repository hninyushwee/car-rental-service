<?php

use App\Http\Controllers\View\BrandController;
use App\Http\Controllers\View\CategoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('user.home');
});
Route::get('/about', function () {
    return view('user.about');
});
Route::get('/contact', function () {
    return view('user.contact');
});
Route::get('/rent_car', function () {
    return view('user.rent_car');
})->name('rent_car');

Route::get('/rent_car_form', function () {
    return view('user.rent_car_form');
})->name('car_form');

Route::get('/home', function () {
    return view('user.dashboard');
})->name('dashboard');

Route::get('/notification', function () {
    return view('user.notification');
})->name('noti');

Route::get('/rent_driver', function () {
    return view('user.rent_driver');
})->name('rent_driver');

Route::get('/rent_driver_form', function () {
    return view('user.rent_driver_form');
})->name('driver_form');

Route::get('/license', function () {
    return view('user.license');
})->name('license');

Route::get('/history', function () {
    return view('user.booking_history');
})->name('history');
Route::get('/inquiry', function () {
    return view('user.inquiry');
})->name('inquiry');

Route::get('/login', function () {
    return view('user.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('user.auth.register');
})->name('register');

Route::get('/profile', function () {
    return view('user.profile');
})->name('profile');

// Admin Routes
Route::prefix('admin')->group(function () {
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/components', function () {
        return view('admin.components');
    })->name('admin.components');

    // Vehicle Management
    Route::get('/vehicles', function () {
        return view('admin.vehicles.index');
    })->name('admin.vehicles.index');
    Route::get('/vehicles/add', function () {
        return view('admin.vehicles.create');
    })->name('admin.vehicles.create');
    Route::get('/vehicles/brands', [BrandController::class, 'index'])->name('admin.brands.index');
    Route::get('/vehicles/categories', [CategoryController::class, 'index'])->name('admin.categories.index');

    // Placeholder routes for other sections
    Route::get('/{section}/{action?}', function ($section, $action = null) {
        return view('admin.dashboard');
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});