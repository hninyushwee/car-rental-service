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
    <div data-page="admin-payments" data-api-base="<?php echo e(url('/api/admin/payments')); ?>" data-admin-url="<?php echo e($adminUrl); ?>" class="p-4 sm:p-6 md:p-8">
        <div id="successBox" class="mb-5 hidden rounded-xl border border-green-500/20 bg-green-500/10 p-4 text-sm text-green-600 dark:text-green-400">
            <div class="flex items-center justify-between">
                <span id="successText"></span>
                <button type="button" class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>
        <div id="errorBox" class="mb-5 hidden rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-600 dark:text-red-400">
            <div class="flex items-center justify-between">
                <span id="errorText"></span>
                <button type="button" class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>

        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Payments</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="credit-card" class="h-3 w-3"></i> Track all payment transactions
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-cyan-500/10 p-1.5"><i data-lucide="dollar-sign" class="h-3.5 w-3.5 text-cyan-600 dark:text-cyan-400"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Revenue</p>
                        <p id="statTotal" class="font-bold text-slate-900 dark:text-white">MMK 0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-green-500/10 p-1.5"><i data-lucide="check-circle" class="h-3.5 w-3.5 text-green-600 dark:text-green-400"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Paid</p>
                        <p id="statPaid" class="font-bold text-green-600 dark:text-green-400">0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-yellow-500/10 p-1.5"><i data-lucide="clock" class="h-3.5 w-3.5 text-yellow-600 dark:text-yellow-400"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Pending</p>
                        <p id="statPending" class="font-bold text-yellow-600 dark:text-yellow-400">0</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-red-500/10 p-1.5"><i data-lucide="x-circle" class="h-3.5 w-3.5 text-red-600 dark:text-red-400"></i></div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Failed</p>
                        <p id="statFailed" class="font-bold text-red-600 dark:text-red-400">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-md flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search payments..." class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm transition-all placeholder:text-slate-400 hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-500">
            </div>
            <div class="flex flex-wrap gap-2">
                <select id="yearFilter" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                    <option value="">All Years</option>
                </select>
                <select id="monthFilter" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                    <option value="">All Months</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
                <select id="dayFilter" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                    <option value="">All Days</option>
                </select>
                <select id="statusFilter" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                    <option value="">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                    <option value="failed">Failed</option>
                    <option value="refunded">Refunded</option>
                </select>
                <button type="button" id="refreshBtn" title="Reload" class="flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                </button>
                <?php if (\Illuminate\Support\Facades\Blade::check('role', 'super-admin')): ?>
                <a href="#" id="exportBtn" class="flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                    <i data-lucide="file-down" class="h-4 w-4 text-emerald-600 dark:text-emerald-400"></i>
                    Export
                </a>
                <?php endif; ?>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Customer</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Transaction</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Method</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="paymentsTableBody">
                        <tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Loading payments...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col gap-3 border-t border-slate-200/60 bg-slate-50/30 px-4 py-3.5 dark:border-slate-700/60 dark:bg-slate-900/10 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Showing <span id="paginationInfoStart">0</span> to <span id="paginationInfoEnd">0</span> of <span id="paginationInfoTotal">0</span> records
                </div>
                <div class="flex items-center justify-end gap-1.5" id="paginationControlsContainer"></div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-800">
            <div class="mb-4 flex items-center gap-3">
                <div class="rounded-full bg-red-500/10 p-2"><i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i></div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Payment</h3>
            </div>
            <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">Are you sure you want to delete this payment record? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button type="button" id="closeDeleteModalBtn" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="flex-1 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">Delete</button>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/payments/index.blade.php ENDPATH**/ ?>