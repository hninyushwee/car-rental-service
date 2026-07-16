<?php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
?>

<?php if (isset($component)) { $__componentOriginalf0ba3803d8e60c3bcf4e550b41c25c90 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf0ba3803d8e60c3bcf4e550b41c25c90 = $attributes; } ?>
<?php $component = App\View\Components\Admin\Layout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Admin\Layout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div
        id="dashboardPage"
        data-page="admin-dashboard"
        data-api-url="<?php echo e(url('/api/admin/dashboard')); ?>"
        data-login-url="<?php echo e(route('login')); ?>"
        data-admin-url="<?php echo e($adminUrl); ?>"
        class="p-4 sm:p-6 md:p-8"
    >
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Dashboard</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="layout-dashboard" class="h-3 w-3"></i>
                        Welcome back, <?php echo e(Auth::user()->name); ?>! Here's what's happening with your business today.
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-cyan-500/10 p-1.5">
                        <i data-lucide="car" class="h-3.5 w-3.5 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Vehicles</p>
                        <p id="statVehicles" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-blue-500/10 p-1.5">
                        <i data-lucide="users" class="h-3.5 w-3.5 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Drivers</p>
                        <p id="statDrivers" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-amber-500/10 p-1.5">
                        <i data-lucide="calendar" class="h-3.5 w-3.5 text-amber-600 dark:text-amber-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Active Bookings</p>
                        <p id="statActiveBookings" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-green-500/10 p-1.5">
                        <i data-lucide="dollar-sign" class="h-3.5 w-3.5 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Monthly Revenue</p>
                        <p id="statRevenue" class="font-bold text-lg text-green-600 dark:text-green-400"><span class="text-sm font-medium text-slate-500 dark:text-slate-400">MMK </span>--</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90 lg:col-span-2">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Revenue Trend</h2>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Booking Status</h2>
                <div class="chart-container">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Vehicle Utilization</h2>
                <div class="chart-container">
                    <canvas id="utilizationChart"></canvas>
                </div>
            </div>

            <div id="licenseTypeContainer" class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Driving License Type</h2>
                <div class="chart-container">
                    <canvas id="licenseTypeChart"></canvas>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white/90 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
            <div class="border-b border-slate-200/60 px-6 py-4 dark:border-slate-700/60">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Bookings</h2>
                    <a href="<?php echo e($adminUrl); ?>/bookings" class="text-sm font-medium text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">View All</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Booking ID</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Customer</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Vehicle</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Pickup Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="recentBookingsBody" class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Loading...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf0ba3803d8e60c3bcf4e550b41c25c90)): ?>
<?php $attributes = $__attributesOriginalf0ba3803d8e60c3bcf4e550b41c25c90; ?>
<?php unset($__attributesOriginalf0ba3803d8e60c3bcf4e550b41c25c90); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf0ba3803d8e60c3bcf4e550b41c25c90)): ?>
<?php $component = $__componentOriginalf0ba3803d8e60c3bcf4e550b41c25c90; ?>
<?php unset($__componentOriginalf0ba3803d8e60c3bcf4e550b41c25c90); ?>
<?php endif; ?>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>