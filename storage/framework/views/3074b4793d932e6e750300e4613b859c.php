<?php if (isset($component)) { $__componentOriginal46b08ee5d46b08a5773b401d0f91183b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal46b08ee5d46b08a5773b401d0f91183b = $attributes; } ?>
<?php $component = App\View\Components\User\Layout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user.layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\User\Layout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['hideFooter' => true]); ?>

<?php $__env->startPush('styles'); ?>
<style>
  .hero-gradient {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f1f5f9 100%);
  }
  .dark .hero-gradient {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e293b 100%);
  }
  .shadow-glow {
    box-shadow: 0 2px 15px rgba(6, 182, 212, 0.12), 0 4px 25px rgba(6, 182, 212, 0.05);
  }
  .dark .shadow-glow {
    box-shadow: 0 2px 15px rgba(6, 182, 212, 0.2), 0 4px 25px rgba(6, 182, 212, 0.08);
  }
</style>
<?php $__env->stopPush(); ?>

<div data-page="rent-driver" data-api-base="<?php echo e(url('/')); ?>" class="min-h-screen">

<!-- Hero Section -->
<div class="hero-gradient py-12 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
  <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
    <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
    <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
  </div>
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
    <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
      Hire a Driver
    </h1>
    <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">Professional drivers, competitive rates, and verified service</p>
    <div class="mt-4 flex justify-center">
      <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
    </div>
  </div>
</div>

<!-- Main Content -->
<div class="bg-white dark:bg-slate-950 pb-16">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Loading State -->
    <div id="loadingState" class="py-16 text-center hidden">
      <div class="inline-block h-8 w-8 animate-spin rounded-full border-4 border-slate-300 border-t-cyan-500"></div>
      <p class="mt-3 text-sm text-slate-500">Loading license types...</p>
    </div>

    <!-- License Types Grid -->
    <div id="licenseTypeGrid" class="py-12 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
    </div>

    <!-- Empty State -->
    <div id="emptyState" class="col-span-full py-16 text-center hidden">
      <i data-lucide="file-badge" class="mx-auto h-14 w-14 text-slate-300 dark:text-slate-600"></i>
      <h3 class="mt-3 text-lg font-bold text-slate-600 dark:text-slate-400">No license types available</h3>
      <p class="mt-1 text-sm text-slate-400 dark:text-slate-500">Check back later for new listings.</p>
    </div>
  </div>
</div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.fade-up').forEach(el => el.classList.add('visible'));
  });
</script>
<?php $__env->stopPush(); ?>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal46b08ee5d46b08a5773b401d0f91183b)): ?>
<?php $attributes = $__attributesOriginal46b08ee5d46b08a5773b401d0f91183b; ?>
<?php unset($__attributesOriginal46b08ee5d46b08a5773b401d0f91183b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal46b08ee5d46b08a5773b401d0f91183b)): ?>
<?php $component = $__componentOriginal46b08ee5d46b08a5773b401d0f91183b; ?>
<?php unset($__componentOriginal46b08ee5d46b08a5773b401d0f91183b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/user/rent_driver.blade.php ENDPATH**/ ?>