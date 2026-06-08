<x-user.layout :hideFooter="true">

@push('styles')
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
  .status-badge {
    @apply inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold;
  }
  .status-open { @apply bg-yellow-100 text-yellow-800; }
  .status-in-progress { @apply bg-blue-100 text-blue-800; }
  .status-resolved { @apply bg-green-100 text-green-800; }
  .status-closed { @apply bg-slate-100 text-slate-800; }
</style>
@endpush

<div class="pt-24 pb-16 bg-white fade-up">
  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <div class="grid gap-8 lg:grid-cols-2">
      {{-- Left column: Inquiry form --}}
      <div>
        <h1 class="text-3xl font-black text-slate-950">General Inquiries</h1>
        <p class="mt-2 text-slate-500">Have a question or feedback? Our support team will get back to you within 24 hours.</p>

        <form id="inquiryForm" class="mt-6 space-y-5">
          <input type="hidden" name="_token" value="demo">
          <div class="grid gap-4 sm:grid-cols-2">
            <div>
              <label class="block text-sm font-medium text-slate-700">Full name *</label>
              <input type="text" value="Demo User" required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
            <div>
              <label class="block text-sm font-medium text-slate-700">Phone number *</label>
              <input type="tel" placeholder="(555) 123-4567" required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
            </div>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Service type *</label>
            <select required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
              <option value="">Select service</option>
              <option>Booking support</option>
              <option>Driver service</option>
              <option>License assistance</option>
              <option>Marketplace inquiry</option>
              <option>Billing & payments</option>
              <option>Technical issue</option>
              <option>General feedback</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Message *</label>
            <textarea rows="4" required placeholder="Please provide as much detail as possible..." class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>
          </div>
          <div>
            <label class="block text-sm font-medium text-slate-700">Attach file (optional)</label>
            <div class="mt-1 flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-4 transition hover:border-cyan-400">
              <i data-lucide="paperclip" class="h-6 w-6 text-slate-400"></i>
              <span class="mt-1 text-xs text-slate-500">Click to upload (image or PDF, max 5MB)</span>
              <input type="file" class="hidden" accept="image/jpeg,image/png,application/pdf">
            </div>
          </div>
          <button type="submit" class="w-full rounded-xl bg-cyan-400 py-3 text-lg font-bold text-slate-950 transition hover:bg-cyan-300 hover:scale-105">Submit Inquiry (Demo)</button>
        </form>
      </div>

      {{-- Right column: Past inquiries list --}}
      <div>
        <div class="flex items-center justify-between mb-4">
          <h2 class="text-xl font-bold text-slate-900">Your inquiries</h2>
          <span class="text-xs text-slate-500" id="inquiryCount">3 total</span>
        </div>
        <div class="space-y-4 max-h-[600px] overflow-y-auto pr-2">
          {{-- Sample inquiry cards (will be populated via JS, but static for demo) --}}
          <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-900">Booking support</p>
                <p class="mt-1 text-xs text-slate-500">Submitted: May 15, 2025</p>
              </div>
              <span class="status-badge status-resolved">Resolved</span>
            </div>
            <p class="mt-2 text-sm text-slate-600">I need help modifying my booking dates for the Tesla rental.</p>
          </div>
          <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-900">Driver service</p>
                <p class="mt-1 text-xs text-slate-500">Submitted: May 10, 2025</p>
              </div>
              <span class="status-badge status-in-progress">In progress</span>
            </div>
            <p class="mt-2 text-sm text-slate-600">Can I request a specific driver for my airport transfer?</p>
          </div>
          <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
            <div class="flex items-start justify-between">
              <div>
                <p class="text-sm font-semibold text-slate-900">Billing & payments</p>
                <p class="mt-1 text-xs text-slate-500">Submitted: May 5, 2025</p>
              </div>
              <span class="status-badge status-open">Open</span>
            </div>
            <p class="mt-2 text-sm text-slate-600">I was charged twice for my reservation. Please check.</p>
          </div>
        </div>
        <p class="mt-4 text-center text-xs text-slate-400">Showing recent 3 of 8 total inquiries</p>
      </div>
    </div>
  </div>
</div>

{{-- Demo toast --}}
<div id="demoToast" class="fixed bottom-4 left-1/2 hidden -translate-x-1/2 transform rounded-lg bg-slate-800 px-6 py-3 text-white shadow-lg z-50"></div>

@push('scripts')
<script>
  const form = document.getElementById('inquiryForm');
  const toast = document.getElementById('demoToast');

  function showToast(message, isError = false) {
    toast.textContent = message;
    toast.classList.remove('bg-slate-800', 'bg-red-600');
    toast.classList.add(isError ? 'bg-red-600' : 'bg-slate-800');
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
  }

  // File upload preview (demo)
  const fileInput = document.querySelector('input[type="file"]');
  const uploadArea = document.querySelector('.border-dashed');
  if (fileInput) {
    fileInput.addEventListener('change', () => {
      if (fileInput.files.length) {
        uploadArea.classList.add('border-cyan-400', 'bg-cyan-50');
        const span = uploadArea.querySelector('span');
        if (span) span.innerText = fileInput.files[0].name;
      } else {
        uploadArea.classList.remove('border-cyan-400', 'bg-cyan-50');
        const span = uploadArea.querySelector('span');
        if (span) span.innerText = 'Click to upload (image or PDF, max 5MB)';
      }
    });
    uploadArea.addEventListener('click', () => fileInput.click());
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    showToast('Demo: Your inquiry has been submitted. We will contact you within 24 hours.', false);
    form.reset();
    // Reset file upload UI
    if (fileInput) {
      fileInput.value = '';
      uploadArea.classList.remove('border-cyan-400', 'bg-cyan-50');
      const span = uploadArea.querySelector('span');
      if (span) span.innerText = 'Click to upload (image or PDF, max 5MB)';
    }
  });

  // Fade-up observer
  const fadeElements = document.querySelectorAll('.fade-up');
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) entry.target.classList.add('visible');
    });
  }, { threshold: 0.1 });
  fadeElements.forEach(el => observer.observe(el));
</script>
@endpush

</x-user.layout>