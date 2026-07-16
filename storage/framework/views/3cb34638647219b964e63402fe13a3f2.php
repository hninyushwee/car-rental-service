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
    <div data-page="admin-promotion-form" data-api-base="<?php echo e(url('/api/admin/promotions')); ?>"
         data-promotion-id="<?php echo e($promotionId); ?>" data-is-edit="<?php echo e(json_encode($isEdit)); ?>"
         class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg"><?php echo e($isEdit ? 'Edit Promotion' : 'Create Promotion'); ?>

                    </h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="tag" class="h-3 w-3"></i>
                        <span><?php echo e($isEdit ? 'Update promotion details' : 'Create a new coupon or discount'); ?></span>
                    </p>
                </div>
                <a href="<?php echo e(route('admin.promotions.index')); ?>" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
            </div>
        </div>

        <form id="promotionForm" class="space-y-5">
            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Promotion Details</h2>
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Code</label>
                        <input type="text" name="code" id="promoCode" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Type</label>
                        <select name="type" id="promoType" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="percentage">Percentage</option>
                            <option value="fixed">Fixed Amount</option>
                        </select>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Value</label>
                        <input type="number" step="0.01" name="value" id="promoValue" required class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Min Amount</label>
                        <input type="number" step="0.01" name="min_amount" id="promoMinAmount" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Max Discount Cap</label>
                        <input type="number" step="0.01" name="max_uses" id="promoMaxUses" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white" placeholder="Unlimited">
                    </div>
                    <div>
                        <label class="mb-1 flex items-center gap-2 text-sm font-medium text-slate-700 dark:text-slate-300">
                            <input type="checkbox" name="is_active" id="promoIsActive" value="1" checked class="rounded border-slate-300 transition focus:ring-2 focus:ring-cyan-500/20 focus:border-cyan-500 focus:outline-none dark:border-slate-600">
                            Active
                        </label>
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Start Date</label>
                        <input type="datetime-local" name="starts_at" id="promoStartDate" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                    <div>
                        <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Expiry Date</label>
                        <input type="datetime-local" name="expires_at" id="promoExpiresAt" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>
                </div>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Description</h2>
                <textarea name="description" id="promoDescription" rows="3" placeholder="Brief description of this promotion" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white"></textarea>
            </section>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-cyan-400 px-6 py-2.5 text-sm font-medium text-black transition hover:bg-cyan-500">
                    <?php echo e($isEdit ? 'Update Coupon' : 'Create Coupon'); ?>

                </button>
                <a href="/admin/promotions" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</a>
            </div>
        </form>

        <div id="formError" class="mt-4 hidden rounded-lg bg-red-500/10 p-3 text-sm text-red-600 dark:text-red-400"></div>
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/admin/promotions/create.blade.php ENDPATH**/ ?>