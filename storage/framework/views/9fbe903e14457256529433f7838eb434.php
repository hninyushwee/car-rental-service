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
        id="formLayoutWrapper"
        data-page="admin-profile"
        data-api-url="<?php echo e(url('/api/admin/profile')); ?>"
        data-index-url="<?php echo e($adminUrl); ?>"
        data-login-url="<?php echo e(route('login')); ?>"
        class="p-4 sm:p-6 md:p-8"
    >
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 id="formPageHeader" class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Manage Profile
                    </h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="user-circle" class="h-3 w-3"></i>
                        <span>Update your account details and password.</span>
                    </p>
                </div>
                <a href="<?php echo e($adminUrl); ?>" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back to Dashboard
                </a>
            </div>
        </div>

        <div id="formAlert" class="hidden mb-6 flex items-center gap-3 rounded-xl border border-cyan-200 bg-cyan-50 px-4 py-3 text-sm text-cyan-800 dark:border-cyan-800 dark:bg-cyan-950/50 dark:text-cyan-300">
            <i data-lucide="info" class="h-5 w-5 flex-shrink-0"></i>
            <span id="formAlertMsg"></span>
            <button type="button" class="close-alert ml-auto" aria-label="Dismiss">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>

        <form id="profileForm" class="space-y-6">
            <?php echo csrf_field(); ?>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Personal Information</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="profileName" class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Full Name</label>
                        <input
                            type="text"
                            id="profileName"
                            name="name"
                            placeholder="Your full name"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>
                    <div>
                        <label for="profileEmail" class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Email Address</label>
                        <input
                            type="email"
                            id="profileEmail"
                            name="email"
                            placeholder="your@email.com"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>
                    <div>
                        <label for="profilePhone" class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Phone Number</label>
                        <input
                            type="tel"
                            id="profilePhone"
                            name="phone"
                            placeholder="+95 9123 456 789"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Change Password</h2>
                <p class="mb-4 text-xs text-slate-500 dark:text-slate-400">Leave blank to keep your current password.</p>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label for="profilePassword" class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">New Password</label>
                        <input
                            type="password"
                            id="profilePassword"
                            name="password"
                            placeholder="New password"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>
                    <div>
                        <label for="profilePasswordConfirmation" class="mb-1.5 block text-xs font-medium text-slate-600 dark:text-slate-400">Confirm New Password</label>
                        <input
                            type="password"
                            id="profilePasswordConfirmation"
                            name="password_confirmation"
                            placeholder="Confirm new password"
                            class="w-full rounded-xl border border-slate-200 bg-white px-3.5 py-2.5 text-sm text-slate-900 placeholder-slate-400 transition focus:border-cyan-400 focus:outline-none focus:ring-2 focus:ring-cyan-400/20 dark:border-slate-700 dark:bg-slate-900 dark:text-white dark:placeholder-slate-500"
                        >
                    </div>
                </div>
            </section>

            <div class="flex items-center gap-3">
                <button
                    type="submit"
                    id="submitFormBtn"
                    class="inline-flex items-center gap-2 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition hover:bg-cyan-500"
                >
                    <i data-lucide="save" class="h-4 w-4"></i>
                    Save Changes
                </button>
                <button
                    type="button"
                    id="resetFormBtn"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700"
                >
                    Reset
                </button>
            </div>
        </form>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/profile/edit.blade.php ENDPATH**/ ?>