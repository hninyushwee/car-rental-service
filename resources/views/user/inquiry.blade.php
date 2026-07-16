<x-user.layout :hideFooter="true">

@push('styles')
<style>
  .hero-gradient {
    background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 50%, #f1f5f9 100%);
  }
  .dark .hero-gradient {
    background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #1e293b 100%);
  }
  .shadow-glow {
    box-shadow: 0 0 12px rgba(6, 182, 212, 0.3);
  }
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
@endpush

<div data-page="user-inquiry">

  <!-- Hero Section -->
  <div class="hero-gradient py-12 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
    <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
        General Inquiries
      </h1>
      <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">Have a question or feedback? Our support team will get back to you within 24 hours.</p>
      <div class="mt-4 flex justify-center">
        <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
      </div>
    </div>
  </div>

  <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8 pb-16">
    <div class="mt-8 grid gap-8 lg:grid-cols-5">
      {{-- Inquiry Form --}}
      <div class="lg:col-span-3">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-8">
          <h2 class="mb-6 text-xl font-bold text-slate-900">Submit an Inquiry</h2>
          <form id="inquiryForm" class="space-y-5">
            <div>
              <label class="block text-sm font-medium text-slate-700">Subject *</label>
              <input type="text" name="subject" required placeholder="Brief subject line" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700">Message *</label>
              <textarea name="message" rows="5" required placeholder="Please provide as much detail as possible..." class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400 resize-none"></textarea>
            </div>
            <button type="submit" class="w-full rounded-lg bg-cyan-400 py-3.5 text-md font-bold text-black shadow-sm transition hover:bg-cyan-500 hover:scale-[1.01] active:scale-[0.99]">
              <i data-lucide="send" class="inline h-5 w-5 mr-2"></i> Submit Inquiry
            </button>
          </form>
        </div>
      </div>

      {{-- Inquiries List Sidebar --}}
      <div class="lg:col-span-2">
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-lg font-bold text-slate-900 dark:text-white">Your Inquiries</h2>
          <span class="text-xs text-slate-500" id="inquiryCount">0 total</span>
        </div>
        <div id="inquiriesList" class="space-y-4 max-h-[600px] overflow-y-auto pr-1">
          <p class="py-8 text-center text-sm text-slate-400">Loading...</p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Toast Component --}}
<div id="demoToast" class="fixed bottom-5 right-5 z-50 hidden rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300"></div>

@push('scripts')
<script>
  document.querySelectorAll('.fade-up').forEach(el => {
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(e => { if (e.isIntersecting) { e.target.classList.add('visible'); observer.unobserve(e.target); } });
    }, { threshold: 0.1 });
    observer.observe(el);
  });
</script>
@endpush

</x-user.layout>
