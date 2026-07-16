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
  .fade-up { opacity: 0; transform: translateY(30px); transition: opacity 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1), transform 0.8s cubic-bezier(0.2, 0.9, 0.4, 1.1); }
  .fade-up.visible { opacity: 1; transform: translateY(0); }
  .payment-radio:checked + .payment-card { 
    border-color: #22d3ee; 
    background-color: rgba(34, 211, 238, 0.08);
    box-shadow: 0 0 0 2px rgba(34, 211, 238, 0.1);
  }
  
  .cart-card {
    background: rgba(255, 255, 255, 0.7);
    backdrop-filter: blur(12px);
    border: 1px solid rgba(226, 232, 240, 0.6);
  }
  
  .dark .cart-card {
    background: rgba(15, 23, 42, 0.7);
    border-color: rgba(51, 65, 85, 0.6);
  }
  
  .cart-item-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(226, 232, 240, 0.4);
  }
  
  .dark .cart-item-card {
    border-color: rgba(51, 65, 85, 0.4);
  }
  
  .cart-item-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.08);
  }
  
  .dark .cart-item-card:hover {
    box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.3);
  }
  
  .summary-card {
    background: linear-gradient(145deg, rgba(255, 255, 255, 0.9), rgba(255, 255, 255, 0.6));
    backdrop-filter: blur(16px);
    border: 1px solid rgba(226, 232, 240, 0.5);
  }
  
  .dark .summary-card {
    background: linear-gradient(145deg, rgba(15, 23, 42, 0.9), rgba(15, 23, 42, 0.6));
    border-color: rgba(51, 65, 85, 0.5);
  }
  
  .gateway-card {
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: 2px solid transparent;
    background: rgba(248, 250, 252, 0.5);
  }
  
  .dark .gateway-card {
    background: rgba(30, 41, 59, 0.5);
  }
  
  .gateway-card:hover {
    transform: scale(1.02);
    border-color: rgba(34, 211, 238, 0.3);
  }
  
  .gateway-card.selected {
    border-color: #22d3ee;
    background: rgba(34, 211, 238, 0.08);
    box-shadow: 0 0 30px -8px rgba(34, 211, 238, 0.15);
  }
  
  .dark .gateway-card.selected {
    background: rgba(34, 211, 238, 0.12);
    box-shadow: 0 0 30px -8px rgba(34, 211, 238, 0.08);
  }
  
  .input-modern {
    background: rgba(248, 250, 252, 0.8);
    backdrop-filter: blur(8px);
    border: 1.5px solid rgba(226, 232, 240, 0.6);
    transition: all 0.3s ease;
  }
  
  .dark .input-modern {
    background: rgba(30, 41, 59, 0.5);
    border-color: rgba(51, 65, 85, 0.6);
  }
  
  .input-modern:focus {
    border-color: #22d3ee;
    box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.1);
    background: white;
  }
  
  .dark .input-modern:focus {
    background: rgba(15, 23, 42, 0.8);
    box-shadow: 0 0 0 4px rgba(34, 211, 238, 0.08);
  }
  
  .btn-primary {
    background: linear-gradient(135deg, #22d3ee, #06b6d4);
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
  }
  
  .btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px -8px rgba(34, 211, 238, 0.4);
  }
  
  .dark .btn-primary:hover {
    box-shadow: 0 12px 30px -8px rgba(34, 211, 238, 0.25);
  }
  
  .btn-primary:active {
    transform: translateY(0);
  }
  
  .btn-primary::after {
    content: '';
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.2), transparent);
    opacity: 0;
    transition: opacity 0.3s;
  }
  
  .btn-primary:hover::after {
    opacity: 1;
  }
  
  .badge-glow {
    box-shadow: 0 0 20px -5px rgba(34, 211, 238, 0.3);
  }
  
  .panel-card {
    background: rgba(248, 250, 252, 0.6);
    backdrop-filter: blur(8px);
    border: 1px solid rgba(226, 232, 240, 0.4);
    transition: all 0.3s ease;
  }
  
  .dark .panel-card {
    background: rgba(30, 41, 59, 0.4);
    border-color: rgba(51, 65, 85, 0.4);
  }
  
  .qr-wrapper {
    background: white;
    padding: 12px;
    border-radius: 16px;
    box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.06);
  }
  
  .dark .qr-wrapper {
    background: rgba(15, 23, 42, 0.8);
    box-shadow: 0 4px 20px -4px rgba(0, 0, 0, 0.2);
  }
  
  .empty-state-icon {
    background: linear-gradient(135deg, rgba(34, 211, 238, 0.1), rgba(6, 182, 212, 0.05));
  }
  
  @keyframes shimmer {
    0% { background-position: -200% 0; }
    100% { background-position: 200% 0; }
  }
  
  .shimmer-loading {
    background: linear-gradient(90deg, rgba(226, 232, 240, 0.3) 25%, rgba(226, 232, 240, 0.5) 50%, rgba(226, 232, 240, 0.3) 75%);
    background-size: 200% 100%;
    animation: shimmer 1.5s infinite;
  }
  
  .dark .shimmer-loading {
    background: linear-gradient(90deg, rgba(51, 65, 85, 0.3) 25%, rgba(51, 65, 85, 0.5) 50%, rgba(51, 65, 85, 0.3) 75%);
    background-size: 200% 100%;
  }
</style>
<?php $__env->stopPush(); ?>

<div data-page="cart-view" data-api-base="<?php echo e(url('/')); ?>" class="pt-8 pb-16 bg-gradient-to-br from-slate-50/80 via-white to-slate-50/60 dark:from-slate-950 dark:via-slate-900 dark:to-slate-950 min-h-screen fade-up">
  <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

    
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
      <div>
        <h1 class="text-3xl font-black text-slate-950 dark:text-white tracking-tight bg-gradient-to-r from-slate-950 to-slate-600 dark:from-white dark:to-slate-300 bg-clip-text text-transparent">
          Your Cart Basket
        </h1>
        <p class="mt-2 text-slate-500 dark:text-slate-400 flex items-center gap-2">
          Review your pending vehicle distributions and fulfill your secure down-payments.
        </p>
      </div>
      <a href="<?php echo e(route('rent_car')); ?>" onclick="history.back(); return false;" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white/70 dark:bg-slate-800/70 backdrop-blur-sm text-sm font-medium text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/70 hover:border-slate-300 dark:hover:border-slate-600 transition-all duration-200 hover:shadow-md">
        <i data-lucide="arrow-left" class="h-4 w-4"></i>
        Back
      </a>
    </div>

    <div class="mt-8 grid gap-8 lg:grid-cols-5">

      
      <div class="lg:col-span-3 space-y-4" id="cartItemsList">
        <div class="cart-card rounded-2xl p-6 space-y-4">
          <div class="flex items-center gap-3">
            <div class="inline-block h-6 w-6 animate-spin rounded-full border-3 border-slate-200 border-t-cyan-400"></div>
            <span class="text-sm text-slate-500 dark:text-slate-400 font-medium">Loading your cart items...</span>
          </div>
        </div>
      </div>

      
      <div class="lg:col-span-2" id="checkoutSidebar">
        <div class="sticky top-24 space-y-6">
          <form id="paymentForm" class="summary-card rounded-2xl p-6 shadow-xl shadow-slate-200/20 dark:shadow-slate-800/10">

            <div class="flex items-center gap-3 pb-4 border-b border-slate-200/60 dark:border-slate-700/60">
              <div class="p-2 rounded-xl bg-cyan-50 dark:bg-cyan-950/30">
                <i data-lucide="credit-card" class="h-5 w-5 text-cyan-500 dark:text-cyan-400"></i>
              </div>
              <h3 class="text-lg font-bold text-slate-900 dark:text-white">Checkout Summary</h3>
            </div>

            
            <div class="mt-5 space-y-3">
              <div class="flex justify-between items-center text-sm">
                <span class="text-slate-500 dark:text-slate-400">Selected Items</span>
                <span class="font-bold text-slate-800 dark:text-slate-200 bg-slate-100 dark:bg-slate-800 px-3 py-0.5 rounded-full" id="cartItemCount">0 Items</span>
              </div>
              <div class="flex justify-between items-center text-sm">
                <span class="text-slate-500 dark:text-slate-400">Subtotal</span>
                <span class="font-mono font-semibold text-slate-800 dark:text-slate-200" id="cartSubtotalRaw">MMK 0</span>
              </div>
              <div id="cartPromoRow" class="hidden flex justify-between items-center text-sm">
                <span class="text-emerald-600 dark:text-emerald-400">Promo <span id="cartPromoLabel"></span></span>
                <span class="font-mono text-emerald-600 dark:text-emerald-400" id="cartPromo">-MMK 0</span>
              </div>
              <div class="flex justify-between items-center text-sm pt-3 mt-2 border-t-2 border-dashed border-slate-200 dark:border-slate-700">
                <span class="font-bold text-emerald-600 dark:text-emerald-400">Total Amount</span>
                <span class="font-mono font-semibold text-emerald-600 dark:text-emerald-400" id="cartTotalPayment">MMK 0</span>
              </div>
              <div class="flex justify-between items-center text-sm">
                <span class="font-bold text-amber-800 dark:text-amber-400">Initial Payment (Not Refund)</span>
                <span class="text-lg font-black text-amber-600 dark:text-amber-400 font-mono tracking-tight" id="cartSubtotal">MMK 0</span>
              </div>
            </div>

            
            <div class="mt-5">
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">Promotion Code</label>
              <div class="flex gap-2">
                <input type="text" id="promoCodeInput" placeholder="Enter coupon code" class="input-modern w-full rounded-xl px-4 py-2 text-sm focus:outline-none text-slate-900 dark:text-slate-100">
                <button type="button" id="applyPromoBtn" class="rounded-xl bg-slate-900 dark:bg-slate-700 px-4 py-2 text-sm font-bold text-white transition hover:bg-slate-800 dark:hover:bg-slate-600 shrink-0">Apply</button>
              </div>
              <span id="promoError" class="hidden text-xs font-medium text-rose-500 mt-1 flex items-center gap-1"></span>
            </div>

            
            <div class="mt-6">
              <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-3">Select Payment Gateway</label>
              <div class="grid grid-cols-3 gap-3">
                <label class="cursor-pointer">
                  <input type="radio" name="payment_method" value="kpay" checked class="peer sr-only payment-radio" onchange="switchPaymentMethod('kpay')">
                  <div class="gateway-card rounded-xl p-3.5 flex flex-col items-center justify-center gap-2 peer-checked:selected">
                    <img src="<?php echo e(asset('images/kbz-logo.webp')); ?>" alt="KBZPay" class="h-8 w-auto object-contain">
                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 tracking-tight">KBZPay</span>
                  </div>
                </label>
                <label class="cursor-pointer">
                  <input type="radio" name="payment_method" value="wavepay" class="peer sr-only payment-radio" onchange="switchPaymentMethod('wavepay')">
                  <div class="gateway-card rounded-xl p-3.5 flex flex-col items-center justify-center gap-2 peer-checked:selected">
                    <img src="<?php echo e(asset('images/wave.jpg')); ?>" alt="WavePay" class="h-8 w-auto object-contain">
                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 tracking-tight">WavePay</span>
                  </div>
                </label>
                <label class="cursor-pointer">
                  <input type="radio" name="payment_method" value="bank_transfer" class="peer sr-only payment-radio" onchange="switchPaymentMethod('bank_transfer')">
                  <div class="gateway-card rounded-xl p-3.5 flex flex-col items-center justify-center gap-2 peer-checked:selected">
                    <img src="<?php echo e(asset('images/kbz.png')); ?>" alt="Bank Transfer" class="h-8 w-auto object-contain">
                    <span class="text-[11px] font-bold text-slate-700 dark:text-slate-300 tracking-tight">Bank Trf</span>
                  </div>
                </label>
              </div>
            </div>

            
            <div class="mt-4 p-4 panel-card rounded-xl transition-all">
              <div id="panel-kpay" class="payment-panel space-y-4">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">KPay Account</p>
                    <p class="text-base font-black font-mono text-slate-900 dark:text-white mt-0.5 tracking-wider">+95 9 795 123 456
                      <button type="button" onclick="copyToClipboard('+95 9 795 123 456')" class="ml-2 inline-flex items-center gap-1 rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-1 text-[10px] font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                        <i data-lucide="copy" class="h-3 w-3"></i> Copy
                      </button>
                    </p>
                  </div>
                  <span class="text-[9px] bg-cyan-100 dark:bg-cyan-950/40 font-bold px-2.5 py-1 rounded-full text-cyan-700 dark:text-cyan-300">Merchant</span>
                </div>
                <div class="qr-wrapper flex flex-col items-center justify-center">
                  <img src="<?php echo e(asset('images/qr_code.png')); ?>" alt="KBZPay QR" class="w-20 h-20 object-contain">
                  <p class="text-[10px] text-slate-400 mt-2 text-center">Scan QR with KbzPay</p>
                </div>
              </div>
              <div id="panel-wavepay" class="payment-panel hidden space-y-4">
                <div class="flex items-center justify-between">
                  <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">WavePay Number</p>
                    <p class="text-base font-black font-mono text-slate-900 dark:text-white mt-0.5 tracking-wider">+95 9 250 888 999
                      <button type="button" onclick="copyToClipboard('+95 9 250 888 999')" class="ml-2 inline-flex items-center gap-1 rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-1 text-[10px] font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                        <i data-lucide="copy" class="h-3 w-3"></i> Copy
                      </button>
                    </p>
                  </div>
                  <span class="text-[9px] bg-blue-100 dark:bg-blue-950/40 font-bold px-2.5 py-1 rounded-full text-blue-700 dark:text-blue-300">Transfer</span>
                </div>
                <div class="qr-wrapper flex flex-col items-center justify-center">
                  <img src="<?php echo e(asset('images/qr_code.png')); ?>" alt="WavePay QR" class="w-20 h-20 object-contain">
                  <p class="text-[10px] text-slate-400 mt-2 text-center">Scan QR with WavePay</p>
                </div>
              </div>
              <div id="panel-bank_transfer" class="payment-panel hidden space-y-4">
                <div>
                  <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">Bank Account Details</p>
                  <p class="text-sm font-black font-mono text-slate-900 dark:text-white mt-0.5 tracking-wider">320-105-999332-1102</p>
                    <button type="button" onclick="copyToClipboard('SkyLine Automotive (KBZ Bank)')" class="ml-2 inline-flex items-center gap-1 rounded-md bg-slate-100 dark:bg-slate-700 px-2 py-1 text-[10px] font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-600 transition">
                      <i data-lucide="copy" class="h-3 w-3"></i> Copy
                    </button>
                  </p>
                </div>
                <div class="rounded-xl border border-slate-200 dark:border-slate-700 bg-gradient-to-br from-slate-800 to-slate-950 p-4 text-white font-mono shadow-lg">
                  <div class="flex justify-between items-center text-xs text-slate-400 font-sans">
                    <span>Gateway</span>
                    <img src="<?php echo e(asset('images/kbz.png')); ?>" alt="KBZ" class="h-6 w-auto object-contain brightness-200">
                  </div>
                  <div class="text-center text-sm font-bold tracking-[0.2em] my-3 opacity-75">**** **** **** 1102</div>
                  <div class="flex justify-between text-[10px] uppercase text-slate-400 font-sans border-t border-slate-700/50 pt-2">
                    <div><span class="block text-[8px]">Holder</span><p class="text-white font-medium text-xs">SKYLINE AUTO</p></div>
                    <div class="text-right"><span class="block text-[8px]">Type</span><p class="text-white font-medium text-xs">KBZ DIRECT</p></div>
                  </div>
                </div>
              </div>
            </div>

            
            <div class="mt-5 space-y-4">
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Transaction Reference</label>
                <input type="text" name="transaction_ref" id="transaction_ref" required placeholder="Enter wallet reference token" class="input-modern w-full rounded-xl px-4 py-2 text-sm focus:outline-none text-slate-900 dark:text-slate-100 font-mono">
              </div>
              <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-1.5">Upload Receipt</label>
                <input type="file" name="image" id="payment_image" accept="image/*" required class="input-modern w-full rounded-xl text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-5 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-slate-100 dark:file:bg-slate-700 file:text-slate-700 dark:file:text-slate-300 hover:file:bg-slate-200 dark:hover:file:bg-slate-600 cursor-pointer transition-all">
              </div>
            </div>

            <button type="submit" id="checkoutBtn" class="btn-primary w-full mt-6 rounded-xl py-2.5 text-md font-bold text-black shadow-lg flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed transition-all" disabled>
                Confirm Booking
            </button>
          </form>
        </div>
      </div>

      
      <div id="cartEmpty" class="hidden lg:col-span-5">
        <div class="summary-card rounded-3xl p-16 text-center">
          <div class="empty-state-icon w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <i data-lucide="shopping-basket" class="h-10 w-10 text-cyan-400"></i>
          </div>
          <h3 class="text-2xl font-bold text-slate-900 dark:text-white">Your basket is empty</h3>
          <p class="text-slate-500 dark:text-slate-400 mt-2 max-w-sm mx-auto">Browse our fleet and add vehicles to your cart to start the distribution process.</p>
          <a href="<?php echo e(route('rent_car')); ?>" class="inline-flex items-center gap-2 mt-6 px-6 py-3 bg-cyan-400 dark:bg-cyan-500 text-black dark:text-white font-bold rounded-xl hover:bg-cyan-500 dark:hover:bg-cyan-400 transition-all hover:shadow-lg hover:-translate-y-0.5">
            <i data-lucide="car" class="h-5 w-5"></i>
            Browse Fleet
          </a>
        </div>
      </div>

    </div>
  </div>
</div>


<div id="cartToast" class="fixed bottom-6 right-6 z-50 hidden rounded-2xl px-6 py-3.5 text-sm font-bold text-white shadow-2xl shadow-black/20 transition-all duration-300 backdrop-blur-sm bg-gradient-to-r from-cyan-500 to-cyan-600"></div>

<?php $__env->startPush('scripts'); ?>
<script>
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => { 
      if (entry.isIntersecting) entry.target.classList.add('visible'); 
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));

  function switchPaymentMethod(method) {
    document.querySelectorAll('.payment-panel').forEach(p => p.classList.add('hidden'));
    const panel = document.getElementById('panel-' + method);
    if (panel) panel.classList.remove('hidden');
  }

  function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(() => {
      const toast = document.getElementById('cartToast');
      toast.textContent = 'Phone number copied!';
      toast.className = 'fixed bottom-6 right-6 z-50 rounded-2xl px-6 py-3.5 text-sm font-bold text-white shadow-2xl shadow-black/20 transition-all duration-300 backdrop-blur-sm bg-gradient-to-r from-emerald-500 to-emerald-600';
      toast.classList.remove('hidden');
      setTimeout(() => toast.classList.add('hidden'), 2500);
    }).catch(() => {
      alert('Failed to copy');
    });
  }

  // Initialize Lucide icons
  document.addEventListener('DOMContentLoaded', function() {
    if (typeof lucide !== 'undefined') {
      lucide.createIcons();
    }
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
<?php endif; ?><?php /**PATH C:\Users\hp\Documents\Portfolio\car-rental-service\resources\views/user/cart_view.blade.php ENDPATH**/ ?>