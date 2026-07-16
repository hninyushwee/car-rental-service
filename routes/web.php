<?php

use App\Http\Controllers\View\Admin\AnalyticsController as ViewAnalyticsController;
use App\Http\Controllers\View\Admin\BookingController;
use App\Http\Controllers\View\Admin\BrandController;
use App\Http\Controllers\View\Admin\CategoryController;
use App\Http\Controllers\View\Admin\CustomerController;
use App\Http\Controllers\View\Admin\DepositSettingController;
use App\Http\Controllers\View\Admin\DriverController;
use App\Http\Controllers\View\Admin\InquiryController;
use App\Http\Controllers\View\Admin\NotificationController as ViewNotificationController;
use App\Http\Controllers\View\Admin\PaymentController;
use App\Http\Controllers\View\Admin\ProfileController;
use App\Http\Controllers\View\Admin\PromotionController;
use App\Http\Controllers\View\Admin\RoleController;
use App\Http\Controllers\View\Admin\StaffController as ViewStaffController;
use App\Http\Controllers\View\Admin\VehicleController;
use App\Http\Controllers\Admin\ExportController;
use App\Http\Controllers\View\User\HomeController;
use App\Http\Controllers\View\User\RentCarController as UserRentCarController;
use App\Http\Controllers\View\User\CartController as UserCartController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->get('/', [HomeController::class, 'index']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/contact', [HomeController::class, 'contact']);

Route::middleware('guest')->group(function () {
    Route::get('/login', function () {
        return view('auth.login', [
            'showRegisterLink' => true,
            'redirect' => '/dashboard',
            'expected_role' => '',
        ]);
    })->name('login');

    Route::get('/admin/login', function () {
        return view('auth.login', [
            'showRegisterLink' => false,
            'redirect' => '/admin',
            'expected_role' => 'super-admin',
        ]);
    })->name('admin.login');

    Route::get('/staff/login', function () {
        return view('auth.login', [
            'showRegisterLink' => false,
            'redirect' => '/staff',
            'expected_role' => 'staff',
        ]);
    })->name('staff.login');

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');
});

Route::middleware('auth')->group(function () {

    // ─── Super-Admin Only (prefix: /admin) ───
    Route::middleware('role:super-admin')->prefix('admin')->group(function () {
        Route::get('/settings/roles', [RoleController::class, 'index'])->name('admin.roles.index');
        Route::get('/settings/roles/add', [RoleController::class, 'create'])->name('admin.roles.create');
        Route::get('/settings/roles/{id}/edit', [RoleController::class, 'edit'])->name('admin.roles.edit');

        Route::get('/staff', [ViewStaffController::class, 'index'])->name('admin.staff.index');
        Route::get('/staff/create', [ViewStaffController::class, 'create'])->name('admin.staff.create');
        Route::get('/staff/{id}/edit', [ViewStaffController::class, 'edit'])->name('admin.staff.edit');

        Route::get('/deposit-settings', [DepositSettingController::class, 'index'])->name('admin.deposit-settings.index');
        Route::get('/deposit-settings/add', [DepositSettingController::class, 'create'])->name('admin.deposit-settings.create');
        Route::get('/deposit-settings/{id}/edit', [DepositSettingController::class, 'edit'])->name('admin.deposit-settings.edit');

        Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
        Route::get('/brands', [BrandController::class, 'index'])->name('admin.brands.index');
        Route::get('/driving-license-types', [\App\Http\Controllers\View\Admin\DrivingLicenseTypeController::class, 'index'])->name('admin.driving-license-types.index');

        Route::get('/vehicles', [VehicleController::class, 'index'])->name('admin.vehicles.index');
        Route::get('/vehicles/add', [VehicleController::class, 'create'])->name('admin.vehicles.create');
        Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('admin.vehicles.show');
        Route::get('/vehicles/{id}/edit', [VehicleController::class, 'edit'])->name('admin.vehicles.edit');

        Route::get('/promotions', [PromotionController::class, 'index'])->name('admin.promotions.index');
        Route::get('/promotions/add', [PromotionController::class, 'create'])->name('admin.promotions.create');
        Route::get('/promotions/{id}', [PromotionController::class, 'show'])->name('admin.promotions.show');
        Route::get('/promotions/{id}/edit', [PromotionController::class, 'edit'])->name('admin.promotions.edit');

        Route::get('/customers', [CustomerController::class, 'index'])->name('admin.customers.index');
        Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('admin.customers.show');

        Route::get('/inquiries', [InquiryController::class, 'index'])->name('admin.inquiries.index');
        Route::get('/inquiries/{id}', [InquiryController::class, 'show'])->name('admin.inquiries.show');

        Route::get('/notifications', [ViewNotificationController::class, 'index'])->name('admin.notifications.index');
        Route::get('/notifications/{id}', [ViewNotificationController::class, 'show'])->name('admin.notifications.show');

        // Shared routes (super-admin access via /admin)
        Route::get('/', fn() => view('admin.dashboard'))->name('admin.dashboard');
        Route::get('/bookings', [BookingController::class, 'index'])->name('admin.bookings.index');
        Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('admin.bookings.show');
        Route::get('/drivers', [DriverController::class, 'index'])->name('admin.drivers.index');
        Route::get('/drivers/add', [DriverController::class, 'create'])->name('admin.drivers.create');
        Route::get('/drivers/{id}', [DriverController::class, 'show'])->name('admin.drivers.show');
        Route::get('/drivers/{id}/edit', [DriverController::class, 'edit'])->name('admin.drivers.edit');
        Route::get('/payments', [PaymentController::class, 'index'])->name('admin.payments.index');
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('admin.payments.show');
        Route::get('/export/bookings', [ExportController::class, 'bookings'])->name('admin.export.bookings');
        Route::get('/export/payments', [ExportController::class, 'payments'])->name('admin.export.payments');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('admin.profile.edit');
        Route::get('/analytics/bookings', [ViewAnalyticsController::class, 'bookings'])->name('admin.analytics.bookings');
        Route::get('/analytics/customers', [ViewAnalyticsController::class, 'customers'])->name('admin.analytics.customers');
    });

    // ─── Staff Only (prefix: /staff) ───
    Route::middleware('role:staff')->prefix('staff')->group(function () {
        Route::get('/', fn() => view('admin.dashboard'))->name('staff.dashboard');

        Route::get('/bookings', [BookingController::class, 'index'])->name('staff.bookings.index')
            ->middleware('permission:view-bookings');
        Route::get('/bookings/{id}', [BookingController::class, 'show'])->name('staff.bookings.show')
            ->middleware('permission:view-booking-details');

        Route::get('/drivers', [DriverController::class, 'index'])->name('staff.drivers.index')
            ->middleware('permission:view-drivers');
        Route::get('/drivers/{id}', [DriverController::class, 'show'])->name('staff.drivers.show')
            ->middleware('permission:view-driver-details');

        Route::get('/vehicles', [VehicleController::class, 'index'])->name('staff.vehicles.index')
            ->middleware('permission:view-vehicles');
        Route::get('/vehicles/{id}', [VehicleController::class, 'show'])->name('staff.vehicles.show')
            ->middleware('permission:view-vehicle-details');

        Route::get('/promotions', [PromotionController::class, 'index'])->name('staff.promotions.index')
            ->middleware('permission:view-promotions');
        Route::get('/promotions/{id}', [PromotionController::class, 'show'])->name('staff.promotions.show')
            ->middleware('permission:view-promotion-details');

        Route::get('/deposit-settings', [DepositSettingController::class, 'index'])->name('staff.deposit-settings.index')
            ->middleware('permission:view-deposit-settings');

        Route::get('/notifications', [ViewNotificationController::class, 'index'])->name('staff.notifications.index')
            ->middleware('permission:view-notifications');
        Route::get('/notifications/{id}', [ViewNotificationController::class, 'show'])->name('staff.notifications.show')
            ->middleware('permission:view-notifications');

        Route::get('/payments', [PaymentController::class, 'index'])->name('staff.payments.index');
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('staff.payments.show');
        Route::get('/export/bookings', [ExportController::class, 'bookings'])->name('staff.export.bookings');
        Route::get('/export/payments', [ExportController::class, 'payments'])->name('staff.export.payments');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('staff.profile.edit');
        Route::get('/analytics/bookings', [ViewAnalyticsController::class, 'bookings'])->name('staff.analytics.bookings');
        Route::get('/analytics/customers', [ViewAnalyticsController::class, 'customers'])->name('staff.analytics.customers');
    });

    // ─── Customer-only routes ───
    Route::middleware('role:customer')->group(function () {
        Route::prefix('dashboard')->name('dashboard')->group(function () {
            Route::get('/', [\App\Http\Controllers\Api\User\CustomerDashboardController::class, 'indexView']);
        });

        Route::get('/rent-car', [UserRentCarController::class, 'index'])->name('rent_car');
        Route::get('/rent-car/create', [UserRentCarController::class, 'create'])->name('car_form');
        Route::get('/cart', [UserCartController::class, 'index'])->name('cart.view');
        Route::get('/rent-driver', fn() => view('user.rent_driver'))->name('rent_driver');
        Route::get('/rent-driver/create', fn() => view('user.rent_driver_form'))->name('driver_form');
        Route::get('/booking-history', fn() => view('user.booking_history'))->name('history');
        Route::get('/inquiries', fn() => view('user.inquiry'))->name('inquiry');
        Route::get('/profile', fn() => view('user.profile'))->name('profile');
        Route::get('/notifications', fn() => view('user.notification'))->name('noti');
    });
});

Route::fallback(function () {
    return response()->view('errors.404', [], 404);
});
