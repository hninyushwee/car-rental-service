<x-admin.layout title="{{ $isEdit ? 'Edit' : 'Create' }} Deposit Setting">
<div data-page="admin-deposit-form" data-api-base="/api/admin/deposit-settings" data-setting-id="{{ $depositSettingId }}" class="p-4 sm:p-6 md:p-8">
  <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div>
        <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">{{ $isEdit ? 'Edit' : 'Create' }} Deposit Setting</h1>
        <p class="mt-0.5 flex items-center gap-2 text-base text-slate-600 dark:text-slate-400">
          <i data-lucide="landmark" class="h-3 w-3"></i>
          <span>Define a global deposit rule for a service type.</span>
        </p>
      </div>
      <a href="{{ route('admin.deposit-settings.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
        <i data-lucide="arrow-left" class="h-3 w-3"></i>
        Back
      </a>
    </div>
  </div>

  <div class="mx-auto max-w-3xl">
    <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-6 shadow-xl backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 sm:p-8">

      <form id="depositSettingForm" class="mt-6 space-y-5">
        <div>
          <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Service Key *</label>
          <input type="text" name="service_key" placeholder="e.g. car_rental" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
          <p class="mt-1 text-xs text-slate-400">Unique identifier, e.g. car_rental, driver_service</p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Deposit Type *</label>
            <select name="deposit_type" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
              <option value="fixed">Fixed ($)</option>
              <option value="percentage">Percentage (%)</option>
            </select>
          </div>
          <div>
            <label class="mb-1 block text-sm font-medium text-slate-700 dark:text-slate-300">Amount *</label>
            <input type="number" step="0.01" min="0" name="amount" placeholder="0.00" class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
          </div>
        </div>

        <div class="flex items-center gap-3">
          <input type="checkbox" name="is_active" value="1" class="h-4 w-4 rounded border-slate-300 text-cyan-500 focus:ring-cyan-500" checked>
          <label class="text-sm text-slate-700 dark:text-slate-300">Active</label>
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button type="submit" class="rounded-lg bg-cyan-400 px-6 py-2.5 text-sm font-semibold text-black transition hover:bg-cyan-500">
            {{ $isEdit ? 'Update' : 'Create' }} Setting
          </button>
          <a href="{{ route('admin.deposit-settings.index') }}" class="rounded-xl border border-slate-300 px-6 py-2.5 text-sm text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script src="{{ mix('js/admin/deposits/deposit-form-page.js') }}"></script>
@endpush
</x-admin.layout>
