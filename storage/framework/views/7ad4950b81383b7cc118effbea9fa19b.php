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
  .fade-up {
    opacity: 0;
    transform: translateY(30px);
    transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1),
                transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1);
  }
  .fade-up.visible {
    opacity: 1;
    transform: translateY(0);
  }
</style>
<?php $__env->stopPush(); ?>

<div data-page="rent-car-form" data-api-base="<?php echo e(url('/')); ?>" data-vehicle-id="<?php echo e(request('vehicle_id')); ?>" class="pt-8 pb-16 bg-slate-50/50 dark:bg-slate-950 min-h-screen fade-up">
  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between">
      <div>
        <h1 class="text-3xl font-black text-slate-950 dark:text-white tracking-tight">Complete your booking</h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400">Review your parameters and confirm your fleet allocation.</p>
      </div>
      <a href="<?php echo e(route('rent_car')); ?>" class="flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-800 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 transition hover:bg-slate-50 dark:hover:bg-slate-700">
        <i data-lucide="arrow-left" class="h-3 w-3"></i>
        Back
      </a>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-5">
      
      <div class="lg:col-span-3">
        <form id="bookingForm" class="space-y-6">

          
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
            <div id="vehicleSummary">
              <div class="flex items-center gap-3 text-sm text-slate-400">
                <div class="inline-block h-5 w-5 animate-spin rounded-full border-2 border-slate-300 border-t-cyan-500"></div>
                Loading vehicle details...
              </div>
            </div>
          </div>

          
          <div class="rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
            <h3 class="text-lg font-bold text-slate-900 dark:text-white flex items-center gap-2">
              <span class="flex h-6 w-6 items-center justify-center rounded-md bg-slate-100 dark:bg-slate-700 text-xs text-slate-700 dark:text-slate-300">1</span>
              Pickup & Return Schedule
            </h3>
            <div class="mt-4 grid gap-4 sm:grid-cols-2">

              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Start date</label>
                <input type="date" id="start_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 dark:border-slate-600 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 text-slate-900 dark:text-slate-100 dark:[color-scheme:dark]">
                <span id="startDateError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">End date</label>
                <input type="date" id="end_date" required class="mt-1.5 w-full rounded-xl border border-slate-200 dark:border-slate-600 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 text-slate-900 dark:text-slate-100 dark:[color-scheme:dark]">
                <span id="endDateError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Pickup location</label>
                <textarea id="pickup_location" rows="2" required placeholder="Enter pickup location" class="mt-1.5 w-full rounded-xl border border-slate-200 dark:border-slate-600 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 text-slate-900 dark:text-slate-100 resize-none"></textarea>
                <span id="pickupLocationError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Dropoff location</label>
                <textarea id="dropoff_location" rows="2" placeholder="Enter dropoff location" class="mt-1.5 w-full rounded-xl border border-slate-200 dark:border-slate-600 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 text-slate-900 dark:text-slate-100 resize-none"></textarea>
                <span id="dropoffLocationError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Quantity</label>
                <div class="mt-1.5 flex items-center gap-2">
                  <button type="button" id="qtyDecrease" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="minus" class="h-4 w-4"></i>
                  </button>
                  <input type="number" id="vehicleQuantity" value="1" min="1" max="99" readonly class="h-9 w-16 rounded-lg border border-slate-200 bg-white text-center text-sm font-bold text-slate-900 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                  <button type="button" id="qtyIncrease" class="flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-slate-50 text-slate-600 hover:bg-slate-100 transition dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                  </button>
                </div>
                <span id="quantityError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Driver</label>
                <label class="mt-1.5 flex cursor-pointer items-center gap-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50/50 dark:bg-slate-800/50 px-4 py-2.5 transition hover:border-cyan-400">
                  <input type="checkbox" id="includeDriver" class="h-5 w-5 rounded border-slate-300 text-cyan-500 focus:ring-cyan-400">
                  <span class="text-sm font-bold text-slate-900 dark:text-white">Include Driver</span>
                </label>
                <span id="driverError" class="mt-1 hidden text-xs font-medium text-rose-500"></span>
              </div>
              <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Notes</label>
                <textarea id="booking_notes" rows="3" placeholder="Any special requests or notes..." class="mt-1.5 w-full rounded-xl border border-slate-200 dark:border-slate-600 px-4 py-2.5 text-sm focus:border-cyan-500 focus:outline-none focus:ring-1 focus:ring-cyan-500 transition-all bg-slate-50/50 dark:bg-slate-800/50 focus:bg-white dark:focus:bg-slate-800 text-slate-900 dark:text-slate-100 resize-none"></textarea>
              </div>
            </div>
          </div>

          <button type="button" id="confirmBookingBtn" class="w-full rounded-lg bg-cyan-400 py-3.5 text-md font-bold text-black shadow-sm transition hover:bg-cyan-500 dark:bg-cyan-500 dark:hover:bg-cyan-400 dark:text-slate-900 hover:scale-[1.01] active:scale-[0.99]">
            <i data-lucide="shopping-cart" class="inline h-5 w-5 mr-2"></i> Add to Cart
          </button>
        </form>
      </div>

      
      <div class="lg:col-span-2">
        <div class="sticky top-24 rounded-2xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 p-6 shadow-sm">
          <h3 class="text-lg font-bold text-slate-900 dark:text-white">Price summary</h3>
          
          <div class="mt-4 space-y-2 text-xs text-slate-500 dark:text-slate-400 border-b border-slate-100 dark:border-slate-700 pb-3 mb-3">
            <div class="flex justify-between">
              <span>Pickup</span>
              <span id="displayPickupDate" class="font-medium text-slate-700 dark:text-slate-300">-</span>
            </div>
            <div class="flex justify-between">
              <span>Return</span>
              <span id="displayReturnDate" class="font-medium text-slate-700 dark:text-slate-300">-</span>
            </div>
            <div class="flex justify-between">
              <span>Pickup location</span>
              <span id="displayPickupLocation" class="font-medium text-slate-700 dark:text-slate-300">-</span>
            </div>
            <div class="flex justify-between">
              <span>Dropoff location</span>
              <span id="displayDropoffLocation" class="font-medium text-slate-700 dark:text-slate-300">-</span>
            </div>
            <div class="flex justify-between">
              <span>Quantity</span>
              <span id="displayQuantity" class="font-medium text-slate-700 dark:text-slate-300">1</span>
            </div>
          </div>
          
          <div class="space-y-3 text-sm">
            <div class="flex justify-between">
              <span class="text-slate-500 dark:text-slate-400">Vehicle Rental (<span id="displayDaysText">0 days</span>)</span>
              <span id="displaySubtotal" class="font-semibold text-slate-800 dark:text-slate-200">MMK 0.00</span>
            </div>
            <div id="driverRateRow" class="hidden flex justify-between">
              <span class="text-slate-500 dark:text-slate-400">Driver Service</span>
              <span id="displayDriverRate" class="font-semibold text-slate-800 dark:text-slate-200">MMK 0.00</span>
            </div>
            
            <div id="depositRow" class="hidden">
              <div class="flex justify-between bg-amber-50 dark:bg-amber-900/20 -mx-6 px-6 py-2 rounded-md border-t border-slate-100 dark:border-slate-700">
                <span class="text-sm font-bold text-amber-700 dark:text-amber-400">Initial Payment (not refund)</span>
                <span id="displayDeposit" class="text-sm font-black text-amber-800 dark:text-amber-300">MMK 0.00</span>
              </div>
            </div>
            
            <div class="border-t border-slate-100 dark:border-slate-700 pt-3 flex justify-between text-lg font-black text-slate-950 dark:text-white">
              <span>Total cost</span>
              <span id="displayTotal">MMK 0.00</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div id="demoToast" class="fixed bottom-5 right-5 z-50 hidden translate-y-0 transform rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300"></div>

<?php $__env->startPush('scripts'); ?>
<script>
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));
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
<?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/user/rent_car_form.blade.php ENDPATH**/ ?>