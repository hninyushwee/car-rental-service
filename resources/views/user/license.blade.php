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
  .file-upload-label {
    @apply flex cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 transition hover:border-cyan-400 hover:bg-cyan-50;
  }
</style>
@endpush

<div class="pt-24 pb-16 fade-up">
  <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
    <div class="text-center ">
      <h1 class="text-3xl font-black text-slate-950">License & Registration Services</h1>
      <p class="mt-2 text-slate-500">Get expert assistance with driving license renewals, new applications, international permits, and more.</p>
    </div>

    <div class="mt-10 rounded-2xl border border-slate-200 bg-white p-6 shadow-md sm:p-8">
      <form id="licenseForm" class="space-y-6">
        <input type="hidden" name="_token" value="demo">

        {{-- Service Type --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Service type *</label>
          <select required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
            <option value="">Select service</option>
            <option>License renewal</option>
            <option>New driving license</option>
            <option>International Driving Permit</option>
            <option>License lost/stolen replacement</option>
            <option>Driver record request</option>
            <option>Other</option>
          </select>
        </div>

        {{-- Office Location --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Preferred office location *</label>
          <select required class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
            <option value="">Select location</option>
            <option>San Francisco DMV</option>
            <option>Los Angeles Service Center</option>
            <option>New York Licensing Office</option>
            <option>Chicago Driver Services</option>
            <option>Online / Mail‑in</option>
          </select>
        </div>

        {{-- Document Upload (photo of license or ID) --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Upload document (photo of license / ID) *</label>
          <div class="mt-1">
            <label class="file-upload-label">
              <i data-lucide="upload-cloud" class="h-10 w-10 text-slate-400"></i>
              <span class="mt-2 text-sm text-slate-500">Click to upload or drag & drop</span>
              <span class="mt-1 text-xs text-slate-400">JPG, PNG or PDF (max 5MB)</span>
              <input type="file" class="hidden" accept="image/jpeg,image/png,application/pdf">
            </label>
          </div>
          <p class="mt-1 text-xs text-slate-400">A clear photo of your current license or government ID is required.</p>
        </div>

        {{-- Appointment Date (optional) --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Preferred appointment date (optional)</label>
          <input type="date" class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400">
        </div>

        {{-- Additional Notes --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Additional notes</label>
          <textarea rows="3" placeholder="Any special requests or information..." class="mt-1 w-full rounded-xl border border-slate-200 px-4 py-2.5 focus:border-cyan-400 focus:outline-none focus:ring-1 focus:ring-cyan-400"></textarea>
        </div>

        {{-- Price Summary (mock) --}}
        <div class="rounded-xl bg-slate-50 p-4">
          <div class="flex justify-between text-sm">
            <span class="text-slate-600">Processing fee</span>
            <span class="font-medium">$49.00</span>
          </div>
          <div class="mt-2 flex justify-between border-t border-slate-200 pt-2 text-base font-bold">
            <span>Total</span>
            <span>$49.00</span>
          </div>
          <p class="mt-2 text-xs text-slate-400">Government fees not included. Payment will be collected after request is reviewed.</p>
        </div>

        <button type="submit" class="w-full rounded-xl bg-cyan-400 py-3 text-lg font-bold text-slate-950 transition hover:bg-cyan-300 hover:scale-105">Submit Request (Demo)</button>
      </form>
    </div>
  </div>
</div>

{{-- Demo toast --}}
<div id="demoToast" class="fixed bottom-4 left-1/2 hidden -translate-x-1/2 transform rounded-lg bg-slate-800 px-6 py-3 text-white shadow-lg"></div>

@push('scripts')
<script>
  const form = document.getElementById('licenseForm');
  const toast = document.getElementById('demoToast');

  function showToast(message, isError = false) {
    toast.textContent = message;
    toast.classList.remove('bg-slate-800', 'bg-red-600');
    toast.classList.add(isError ? 'bg-red-600' : 'bg-slate-800');
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
  }

  // Simulate file upload preview (optional)
  const fileInput = document.querySelector('input[type="file"]');
  const fileLabel = document.querySelector('.file-upload-label');
  if (fileInput) {
    fileInput.addEventListener('change', () => {
      if (fileInput.files.length) {
        fileLabel.classList.add('border-cyan-400', 'bg-cyan-50');
        const span = fileLabel.querySelector('span:not(.text-xs)');
        if (span) span.innerText = fileInput.files[0].name;
      } else {
        fileLabel.classList.remove('border-cyan-400', 'bg-cyan-50');
        const span = fileLabel.querySelector('span:not(.text-xs)');
        if (span) span.innerText = 'Click to upload or drag & drop';
      }
    });
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    showToast('Demo: Your license service request has been submitted. We will contact you within 24 hours.', false);
    // Optionally reset form here
    // form.reset();
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