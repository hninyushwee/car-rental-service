<?php

use App\Http\Controllers\Api\Admin\AnalyticsController as AdminAnalyticsController;
use App\Http\Controllers\Api\Admin\BookingController;
use App\Http\Controllers\Api\Admin\BrandController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\DepositSettingController;
use App\Http\Controllers\Api\Admin\DriverController;
use App\Http\Controllers\Api\Admin\InquiryController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\Admin\PromotionController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Admin\VehicleController;
use App\Http\Controllers\Api\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Api\Admin\NotificationController as AdminNotificationController;
use App\Http\Controllers\Api\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Api\User\CustomerDashboardController;
use App\Http\Controllers\Api\User\RentCarController as UserRentCarController;
use App\Http\Controllers\Auth\AuthApiController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthApiController::class, 'register'])->middleware('throttle:5,1')->name('api.register');
Route::post('/login', [AuthApiController::class, 'login'])->middleware('throttle:5,1')->name('api.login');

Route::middleware('auth:sanctum')->group(function () {

    // ─── Super-Admin Only ───
    Route::middleware('role:super-admin')->prefix('admin')->name('api.')->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

        Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
        Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
        Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
        Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

        Route::post('/drivers', [DriverController::class, 'store'])->name('drivers.store');
        Route::put('/drivers/{driver}', [DriverController::class, 'update'])->name('drivers.update');
        Route::delete('/drivers/{driver}', [DriverController::class, 'destroy'])->name('drivers.destroy');

        Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');
        Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');
        Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');

        Route::post('/promotions', [PromotionController::class, 'store'])->name('promotions.store');
        Route::put('/promotions/{promotion}', [PromotionController::class, 'update'])->name('promotions.update');
        Route::delete('/promotions/{promotion}', [PromotionController::class, 'destroy'])->name('promotions.destroy');

        Route::post('/inquiries', [InquiryController::class, 'store'])->name('inquiries.store');
        Route::delete('/inquiries/{inquiry}', [InquiryController::class, 'destroy'])->name('inquiries.destroy');

        Route::get('/driving-license-types', [\App\Http\Controllers\Api\Admin\DrivingLicenseTypeController::class, 'index'])->name('driving-license-types.index');
        Route::post('/driving-license-types', [\App\Http\Controllers\Api\Admin\DrivingLicenseTypeController::class, 'store'])->name('driving-license-types.store');
        Route::put('/driving-license-types/{drivingLicenseType}', [\App\Http\Controllers\Api\Admin\DrivingLicenseTypeController::class, 'update'])->name('driving-license-types.update');
        Route::delete('/driving-license-types/{drivingLicenseType}', [\App\Http\Controllers\Api\Admin\DrivingLicenseTypeController::class, 'destroy'])->name('driving-license-types.destroy');

        Route::get('/roles', [RoleController::class, 'index'])->name('roles.index');
        Route::post('/roles', [RoleController::class, 'store'])->name('roles.store');
        Route::get('/roles/{role}', [RoleController::class, 'show'])->name('roles.show');
        Route::put('/roles/{role}', [RoleController::class, 'update'])->name('roles.update');
        Route::delete('/roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
        Route::get('/permissions', [RoleController::class, 'permissions'])->name('permissions.index');

        Route::post('/deposit-settings', [DepositSettingController::class, 'store'])->name('deposit-settings.store');
        Route::put('/deposit-settings/{depositSetting}', [DepositSettingController::class, 'update'])->name('deposit-settings.update');
        Route::delete('/deposit-settings/{depositSetting}', [DepositSettingController::class, 'destroy'])->name('deposit-settings.destroy');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/staff', [AdminStaffController::class, 'index'])->name('admin.staff.index');
        Route::post('/staff', [AdminStaffController::class, 'store'])->name('admin.staff.store');
        Route::get('/staff/{user}', [AdminStaffController::class, 'show'])->name('admin.staff.show');
        Route::put('/staff/{user}', [AdminStaffController::class, 'update'])->name('admin.staff.update');
        Route::delete('/staff/{user}', [AdminStaffController::class, 'destroy'])->name('admin.staff.destroy');
    });

    // ─── Super-Admin + Staff ───
    Route::middleware('role:super-admin|staff')->prefix('admin')->name('api.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        Route::get('/bookings', [BookingController::class, 'index'])->name('bookings.index');
        Route::get('/bookings/{booking}', [BookingController::class, 'show'])->name('bookings.show');
        Route::put('/bookings/{booking}', [BookingController::class, 'update'])->name('bookings.update');
        Route::put('/bookings/{booking}/reject', [BookingController::class, 'reject'])->name('bookings.reject');
        Route::get('/bookings/{booking}/items/{item}/available-drivers', [BookingController::class, 'availableDrivers'])->name('bookings.available-drivers');
        Route::put('/bookings/{booking}/items/{item}/assign-driver', [BookingController::class, 'assignDriver'])->name('bookings.assign-driver');
        Route::put('/bookings/{booking}/confirm', [BookingController::class, 'confirm'])->name('bookings.confirm');
        Route::post('/bookings/{booking}/send-invoice', [BookingController::class, 'sendInvoice'])->name('bookings.send-invoice');

        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::post('/payments', [PaymentController::class, 'store'])->name('payments.store');
        Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
        Route::put('/payments/{payment}', [PaymentController::class, 'update'])->name('payments.update');
        Route::delete('/payments/{payment}', [PaymentController::class, 'destroy'])->name('payments.destroy');

        Route::get('/profile', [AdminProfileController::class, 'show'])->name('admin.profile.show');
        Route::post('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

        Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('/notifications/latest', [AdminNotificationController::class, 'latest'])->name('admin.notifications.latest');
        Route::get('/notifications/unread-count', [AdminNotificationController::class, 'unreadCount'])->name('admin.notifications.unread-count');
        Route::get('/notifications/{id}', [AdminNotificationController::class, 'show'])->name('admin.notifications.show');
        Route::put('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('admin.notifications.read');

        Route::get('/vehicles', [VehicleController::class, 'index'])->name('vehicles.index');
        Route::get('/vehicles/{vehicle}', [VehicleController::class, 'show'])->name('vehicles.show');

        Route::get('/drivers', [DriverController::class, 'index'])->name('drivers.index');
        Route::get('/drivers/{driver}', [DriverController::class, 'show'])->name('drivers.show');
        Route::put('/drivers/{driver}/status', [DriverController::class, 'updateStatus'])->name('drivers.status');

        Route::get('/analytics/bookings', [AdminAnalyticsController::class, 'bookings'])->name('analytics.bookings');
        Route::get('/analytics/customers', [AdminAnalyticsController::class, 'customers'])->name('analytics.customers');

        Route::get('/promotions', [PromotionController::class, 'index'])->name('promotions.index');
        Route::get('/promotions/{promotion}', [PromotionController::class, 'show'])->name('promotions.show');

        Route::get('/deposit-settings', [DepositSettingController::class, 'index'])->name('deposit-settings.index');
        Route::get('/deposit-settings/{depositSetting}', [DepositSettingController::class, 'show'])->name('deposit-settings.show');

        Route::get('/inquiries', [InquiryController::class, 'index'])->name('inquiries.index');
        Route::get('/inquiries/{inquiry}', [InquiryController::class, 'show'])->name('inquiries.show');
        Route::put('/inquiries/{inquiry}', [InquiryController::class, 'update'])->name('inquiries.update');
    });

    // ─── Customer ───
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/rent-car', [UserRentCarController::class, 'vehicleIndex'])->name('rent-car.index');
        Route::get('/rent-car/{id}', [UserRentCarController::class, 'vehicleShow'])->name('rent-car.show');
        Route::post('/rent-car/{id}/check-availability', [UserRentCarController::class, 'checkAvailability'])->name('rent-car.check-availability');
        Route::post('/rent-car/{id}/check-driver-availability', [UserRentCarController::class, 'checkVehicleDriverAvailability'])->name('rent-car.check-driver-availability');
        Route::get('/rent-car-promotions', [UserRentCarController::class, 'promotions'])->name('rent-car.promotions');
        Route::get('/rent-car-deposit', [UserRentCarController::class, 'deposit'])->name('rent-car.deposit');
        Route::get('/drivers', [UserRentCarController::class, 'driverIndex'])->name('drivers.index');
        Route::get('/drivers/{driver}', [UserRentCarController::class, 'driverShow'])->name('drivers.show');
        Route::post('/drivers/{driver}/check-availability', [UserRentCarController::class, 'checkDriverAvailability'])->name('drivers.check-availability');
        Route::get('/driving-license-types', [UserRentCarController::class, 'licenseTypeIndex'])->name('driving-license-types.index');
        Route::get('/driving-license-types/{drivingLicenseType}', [UserRentCarController::class, 'licenseTypeShow'])->name('driving-license-types.show');
        Route::post('/driving-license-types/{drivingLicenseType}/check-availability', [UserRentCarController::class, 'checkLicenseTypeDriverAvailability'])->name('driving-license-types.check-availability');
        Route::post('/promotions/{code}/check-usage', [UserRentCarController::class, 'checkPromoUsage'])->name('promotions.check-usage');
        Route::get('/dashboard', [CustomerDashboardController::class, 'index']);
        Route::post('/dashboard/book', [CustomerDashboardController::class, 'store']);

        Route::get('/bookings', [\App\Http\Controllers\Api\User\BookingController::class, 'index']);
        Route::post('/bookings', [\App\Http\Controllers\Api\User\BookingController::class, 'store']);
        Route::get('/bookings/{booking}', [\App\Http\Controllers\Api\User\BookingController::class, 'show']);
        Route::post('/cart/checkout', [\App\Http\Controllers\Api\User\BookingController::class, 'checkout']);
        Route::post('/bookings/{booking}/cancel', [\App\Http\Controllers\Api\User\BookingController::class, 'cancel']);
        Route::post('/bookings/{booking}/items/{item}/cancel', [\App\Http\Controllers\Api\User\BookingController::class, 'cancelItem']);

        Route::get('/inquiries', [\App\Http\Controllers\Api\User\InquiryController::class, 'index']);
        Route::post('/inquiries', [\App\Http\Controllers\Api\User\InquiryController::class, 'store']);
        Route::get('/inquiries/{inquiry}', [\App\Http\Controllers\Api\User\InquiryController::class, 'show']);

        Route::get('/notifications', [\App\Http\Controllers\Api\User\NotificationController::class, 'index']);
        Route::get('/notifications/unread-count', [\App\Http\Controllers\Api\User\NotificationController::class, 'unreadCount']);
        Route::put('/notifications/{notification}/read', [\App\Http\Controllers\Api\User\NotificationController::class, 'markAsRead']);
    });

    Route::post('/logout', [AuthApiController::class, 'logout'])->name('logout');
});
