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
    <div data-page="admin-notifications" data-api-base="<?php echo e(url('/api/admin/notifications')); ?>" data-login-url="<?php echo e(route('login')); ?>" class="p-4 sm:p-6 md:p-8">
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
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Notifications</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="bell" class="h-3 w-3"></i>
                        View all system notifications
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-md flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by title or message..." class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm transition-all placeholder:text-slate-400 hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-500">
            </div>

            <div class="flex flex-wrap gap-2">
                <input type="date" id="dateFrom" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                <input type="date" id="dateTo" class="rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                <select id="statusFilter" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
                    <option value="">All Status</option>
                    <option value="unread">Unread</option>
                    <option value="read">Read</option>
                </select>
                <button type="button" id="refreshBtn" title="Reload" class="flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">User</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Message</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Date</th>
                            <th class="w-16 px-4 py-3 text-center text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Action</th>
                        </tr>
                    </thead>
                    <tbody id="notificationsTableBody">
                        <tr>
                            <td colspan="6" class="px-4 py-12 text-center text-slate-400">Loading notifications...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-200/60 bg-slate-50/30 px-4 py-3.5 dark:border-slate-700/60 dark:bg-slate-900/10 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Showing <span id="paginationInfoStart" class="font-medium text-slate-700 dark:text-slate-300">0</span> to
                    <span id="paginationInfoEnd" class="font-medium text-slate-700 dark:text-slate-300">0</span> of
                    <span id="paginationInfoTotal" class="font-medium text-slate-700 dark:text-slate-300">0</span>
                    records
                </div>
                <div class="flex items-center justify-end gap-1.5" id="paginationControlsContainer"></div>
            </div>
        </div>
    </div>

    <!-- Notification Detail Modal -->
    <div id="notificationDetailModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="relative mx-4 w-full max-w-2xl max-h-[85vh] overflow-y-auto rounded-2xl bg-white p-0 shadow-2xl dark:bg-slate-800">
            <div id="notificationModalBody" class="p-6"></div>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>