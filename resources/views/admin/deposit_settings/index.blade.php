<x-admin.layout title="Deposit Settings">
<div data-page="admin-deposit-settings" data-api-base="/api/admin/deposit-settings" data-is-super-admin="{{ auth()->user()->hasRole('super-admin') ? 'true' : 'false' }}" class="p-4 sm:p-6 md:p-8">
  <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
    <div class="flex flex-wrap items-center justify-between gap-3">
      <div>
        <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Deposit Settings</h1>
        <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
          <i data-lucide="banknote" class="h-3 w-3"></i>
          Manage global deposit rules for services.
        </p>
      </div>
      @role('super-admin')
      <a href="{{ route('admin.deposit-settings.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-semibold text-black shadow-sm transition-all hover:bg-cyan-500">
        <i data-lucide="plus" class="h-4 w-4"></i>Add Deposit Amount
      </a>
      @endrole
    </div>
  </div>



    <div class="mb-5 flex flex-wrap items-center gap-3">
      <div class="relative flex-1 sm:max-w-xs">
        <i data-lucide="search" class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
        <input type="text" id="searchInput" placeholder="Search by service key..." class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
      </div>
      <select id="activeFilter" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:hover:border-slate-500">
        <option value="">All</option>
        <option value="1">Active</option>
        <option value="0">Inactive</option>
      </select>
      <button type="button" id="refreshBtn" title="Reload" class="flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
        <i data-lucide="refresh-cw" class="h-4 w-4"></i>
      </button>
    </div>

    <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead>
            <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
              <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">#</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Service Key</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Type</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Amount</th>
              <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
              <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
            </tr>
          </thead>
          <tbody id="depositSettingsTableBody">
            <tr><td colspan="6" class="px-4 py-12 text-center text-slate-400">Loading deposit settings...</td></tr>
          </tbody>
        </table>
      </div>
      <div class="flex flex-col gap-3 border-t border-slate-200/60 bg-slate-50/30 px-4 py-3.5 dark:border-slate-700/60 dark:bg-slate-900/10 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-xs text-slate-500 dark:text-slate-400">
          Showing <span id="paginationInfoStart">0</span>–<span id="paginationInfoEnd">0</span> of <span id="paginationInfoTotal">0</span>
        </div>
        <div id="paginationControlsContainer" class="flex items-center gap-1"></div>
      </div>
    </div>
  </div>

  <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/40 backdrop-blur-sm">
    <div class="w-full max-w-md rounded-2xl border border-slate-200/60 bg-white p-6 shadow-2xl dark:border-slate-700/60 dark:bg-slate-800">
      <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Setting</h3>
      <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Are you sure you want to delete this deposit setting? This action cannot be undone.</p>
      <div class="mt-6 flex justify-end gap-3">
        <button type="button" id="closeDeleteModalBtn" class="rounded-lg border border-slate-300 px-4 py-2 text-sm text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
        <button type="button" id="confirmDeleteBtn" class="rounded-lg bg-red-500 px-4 py-2 text-sm font-medium text-white transition hover:bg-red-600">Delete</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script src="{{ mix('js/admin/deposits/deposit-page.js') }}"></script>
@endpush
</x-admin.layout>
