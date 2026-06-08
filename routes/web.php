<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('/about', function () {
//     return view('user.about');
// });
// Route::get('/contact', function () {
//     return view('user.contact');
// });
// Route::get('/rent_car', function () {
//     return view('user.rent_car');
// })->name('rent_car');

// Route::get('/rent_car_form', function () {
//     return view('user.rent_car_form');
// })->name('car_form');

// Route::get('/home', function () {
//     return view('user.dashboard');
// })->name('dashboard');

// Route::get('/notification', function () {
//     return view('user.notification');
// })->name('noti');

// Route::get('/rent_driver', function () {
//     return view('user.rent_driver');
// })->name('rent_driver');

// Route::get('/rent_driver_form', function () {
//     return view('user.rent_driver_form');
// })->name('driver_form');

// Route::get('/license', function () {
//     return view('user.license');
// })->name('license');

// Route::get('/history', function () {
//     return view('user.booking_history');
// })->name('history');
// Route::get('/inquiry', function () {
//     return view('user.inquiry');
// })->name('inquiry');

// Route::get('/login', function () {
//     return view('user.login');
// })->name('login');

Route::get('/welcome', function () {
    return Inertia::render('Welcome', [
        'message' => 'Hello from the backend router!'
    ]);
});