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
    <div data-page="admin-analytics-bookings" data-api-url="<?php echo e(url('/api/admin/analytics/bookings')); ?>" data-login-url="<?php echo e(route('login')); ?>" data-admin-url="<?php echo e($adminUrl); ?>" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Booking Analytics</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="bar-chart-3" class="h-3 w-3"></i>
                        Track booking trends and distributions.
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3 lg:grid-cols-6">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-cyan-500/10 p-1.5">
                        <i data-lucide="calendar" class="h-3.5 w-3.5 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Bookings</p>
                        <p id="statTotalBookings" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-green-500/10 p-1.5">
                        <i data-lucide="check-circle" class="h-3.5 w-3.5 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Active</p>
                        <p id="statActive" class="font-bold text-lg text-green-600 dark:text-green-400">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-yellow-500/10 p-1.5">
                        <i data-lucide="clock" class="h-3.5 w-3.5 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Pending</p>
                        <p id="statPending" class="font-bold text-lg text-yellow-600 dark:text-yellow-400">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-orange-500/10 p-1.5">
                        <i data-lucide="car" class="h-3.5 w-3.5 text-orange-600 dark:text-orange-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Vehicle Only</p>
                        <p id="statVehicle" class="font-bold text-lg text-orange-600 dark:text-orange-400">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-purple-500/10 p-1.5">
                        <i data-lucide="user-round" class="h-3.5 w-3.5 text-purple-600 dark:text-purple-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Driver Only</p>
                        <p id="statDriverOnly" class="font-bold text-lg text-purple-600 dark:text-purple-400">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-pink-500/10 p-1.5">
                        <i data-lucide="user-plus" class="h-3.5 w-3.5 text-pink-600 dark:text-pink-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Driver + Vehicle</p>
                        <p id="statDriverVehicle" class="font-bold text-lg text-pink-600 dark:text-pink-400">--</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Booking Trend</h2>
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Booking Types</h2>
                <div class="chart-container">
                    <canvas id="comparisonChart"></canvas>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white/90 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
            <div class="border-b border-slate-200/60 px-6 py-4 dark:border-slate-700/60">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Bookings</h2>
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
                        </tr>
                    </thead>
                    <tbody id="recentBookingsBody" class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                        <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Loading...</td></tr>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/analytics/bookings.blade.php ENDPATH**/ ?>