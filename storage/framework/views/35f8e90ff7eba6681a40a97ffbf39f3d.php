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
    <div data-page="admin-roles" data-api-base="<?php echo e(url('/api/admin/roles')); ?>" class="p-4 sm:p-6 md:p-8">
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
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Roles</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-base text-slate-600 dark:text-slate-400">
                        <i data-lucide="shield" class="h-3 w-3"></i> Manage user roles and permissions
                    </p>
                </div>
                <a href="<?php echo e(url('/admin/settings/roles/add')); ?>" class="group flex items-center gap-2 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-medium text-black shadow-sm transition-all hover:bg-cyan-500">
                    <i data-lucide="plus" class="h-5 w-5 transition-transform group-hover:rotate-90"></i> Add Role
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Users</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Created</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="rolesTableBody">
                        <tr><td colspan="5" class="px-4 py-12 text-center text-slate-400">Loading roles...</td></tr>
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
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Role</h3>
            </div>
            <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">Are you sure you want to delete this role? This action cannot be undone.</p>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/roles/index.blade.php ENDPATH**/ ?>