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

<div data-page="user-notifications">

  <div class="hero-gradient py-8 relative overflow-hidden shadow-lg shadow-cyan-500/5 dark:shadow-cyan-400/10">
    <div class="absolute inset-0 overflow-hidden opacity-10 dark:opacity-15">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-cyan-400 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-blue-400 rounded-full blur-3xl"></div>
    </div>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center relative z-10">
      <h1 class="text-2xl md:text-4xl font-black bg-gradient-to-r from-cyan-500 to-cyan-400 dark:from-cyan-400 dark:to-cyan-300 bg-clip-text text-transparent drop-shadow-sm">
        Notifications
      </h1>
      <p class="mt-2 text-sm text-slate-600 dark:text-slate-300 font-medium">Stay updated with your latest activity and alerts.</p>
      <div class="mt-4 flex items-center justify-center gap-2">
        <span class="text-sm text-slate-500 dark:text-slate-400">Unread:</span>
        <span id="unreadCount" class="text-lg font-bold text-cyan-600 dark:text-cyan-400">0</span>
        <span class="text-xs text-slate-400 dark:text-slate-500">Total: <span id="notificationCount">0</span></span>
      </div>
      <div class="mt-4 flex justify-center">
        <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-cyan-400 to-transparent rounded-full shadow-glow"></div>
      </div>
    </div>
  </div>

  <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pb-16 -mt-4 relative z-10">
    <div id="notificationsList" class="grid gap-3 fade-up">
      <div class="col-span-full py-16 text-center">
        <i data-lucide="bell-off" class="mx-auto h-12 w-12 text-slate-300 dark:text-slate-600"></i>
        <p class="mt-4 text-sm text-slate-400">Loading...</p>
      </div>
    </div>
  </div>
</div>

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
