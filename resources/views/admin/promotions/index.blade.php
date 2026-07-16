<x-admin.layout>
    <div data-page="admin-promotions" data-api-base="{{ url('/api/admin/promotions') }}" data-is-super-admin="{{ auth()->user()->hasRole('super-admin') ? 'true' : 'false' }}" class="p-4 sm:p-6 md:p-8">
        <div id="successBox" class="mb-5 hidden rounded-xl border border-green-500/20 bg-green-500/10 p-4 text-sm text-green-600 dark:text-green-400">
            <div class="flex items-center justify-between">
                <span id="successText"></span>
                <button type="button" class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>
        <div id="errorBox" class="mb-5 hidden rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-600 dark:text-red-400">
            <div class="flex items-center justify-between">
                <span id="errorText"></span>
                <button type="button" class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>

        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Promotions</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="tag" class="h-3 w-3"></i> Manage coupons and discounts
                    </p>
                </div>
                @role('super-admin')
                <a href="{{ url('/admin/promotions/add') }}" class="group flex items-center gap-2 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-medium text-black shadow-sm transition-all hover:bg-cyan-500">
                    <i data-lucide="plus" class="h-5 w-5 transition-transform group-hover:rotate-90"></i> Add Promotion
                </a>
                @endrole
            </div>
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-md flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by code..." class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm transition-all placeholder:text-slate-400 hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder:text-slate-500 dark:hover:border-slate-500">
            </div>
            <div class="flex gap-2">
                <button type="button" id="refreshBtn" title="Reload" class="flex items-center justify-center rounded-xl border border-slate-300 px-4 py-2.5 text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">#</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Code</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Value</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Uses</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Expires</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Active</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="promotionsTableBody">
                        <tr><td colspan="8" class="px-4 py-12 text-center text-slate-400">Loading promotions...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col gap-3 border-t border-slate-200/60 bg-slate-50/30 px-4 py-3.5 dark:border-slate-700/60 dark:bg-slate-900/10 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Showing <span id="paginationInfoStart">0</span> to <span id="paginationInfoEnd">0</span> of <span id="paginationInfoTotal">0</span> records
                </div>
                <div class="flex items-center justify-end gap-1.5" id="paginationControlsContainer"></div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-800">
            <div class="mb-4 flex items-center gap-3">
                <div class="rounded-full bg-red-500/10 p-2"><i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i></div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Promotion</h3>
            </div>
            <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">Are you sure you want to delete this promotion? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button type="button" id="closeDeleteModalBtn" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="flex-1 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">Delete</button>
            </div>
        </div>
    </div>
</x-admin.layout>
