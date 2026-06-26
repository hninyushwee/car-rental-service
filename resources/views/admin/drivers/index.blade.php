<x-admin.layout>
    <div data-page="admin-drivers" data-api-base="{{ url('/api/admin/drivers') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 backdrop-blur-sm dark:border-cyan-500/10 sm:px-5 sm:py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-xl font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-2xl">Drivers</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <i data-lucide="id-card" class="h-4 w-4"></i>
                        Manage driver profiles, rates, and availability.
                    </p>
                </div>
                <a href="{{ route('admin.drivers.create') }}" class="group flex items-center gap-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:scale-[1.02] hover:shadow-xl">
                    <i data-lucide="plus" class="h-5 w-5 transition-transform group-hover:rotate-90"></i>
                    Add New Driver
                </a>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-cyan-500/10 p-2"><i data-lucide="users" class="h-5 w-5 text-cyan-600 dark:text-cyan-400"></i></div>
                    <div><p class="text-xs text-slate-500 dark:text-slate-400">Total Drivers</p><p id="statTotal" class="text-xl font-bold text-slate-900 dark:text-white">0</p></div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-green-500/10 p-2"><i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400"></i></div>
                    <div><p class="text-xs text-slate-500 dark:text-slate-400">Available</p><p id="statAvailable" class="text-xl font-bold text-green-600 dark:text-green-400">0</p></div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-yellow-500/10 p-2"><i data-lucide="route" class="h-5 w-5 text-yellow-600 dark:text-yellow-400"></i></div>
                    <div><p class="text-xs text-slate-500 dark:text-slate-400">On Trip</p><p id="statOnTrip" class="text-xl font-bold text-yellow-600 dark:text-yellow-400">0</p></div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-4 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-slate-500/10 p-2"><i data-lucide="moon" class="h-5 w-5 text-slate-600 dark:text-slate-300"></i></div>
                    <div><p class="text-xs text-slate-500 dark:text-slate-400">Off Duty</p><p id="statOffDuty" class="text-xl font-bold text-slate-600 dark:text-slate-300">0</p></div>
                </div>
            </div>
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative max-w-md flex-1">
                <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by name, phone, license..." class="w-full rounded-xl border border-slate-300 bg-white py-2.5 pl-9 pr-4 text-sm transition-all placeholder:text-slate-400 hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" class="rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm transition-all hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="on_trip">On Trip</option>
                    <option value="off_duty">Off Duty</option>
                </select>
                <button type="button" id="refreshBtn" class="flex items-center justify-center gap-2 rounded-xl border border-slate-300 px-4 py-2.5 text-sm text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i><span>Reload</span>
                </button>
            </div>
        </div>

        <div class="overflow-hidden rounded-2xl border border-slate-200/60 bg-white/90 shadow-xl shadow-slate-200/50 backdrop-blur-sm dark:border-slate-700/60 dark:bg-slate-800/90 dark:shadow-slate-900/50">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="w-12 px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">No</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Driver</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Phone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">License</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Rate</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="driversTableBody">
                        <tr><td colspan="7" class="px-4 py-12 text-center text-slate-400">Loading drivers...</td></tr>
                    </tbody>
                </table>
            </div>
            <div class="flex flex-col gap-3 border-t border-slate-200/60 bg-slate-50/30 px-4 py-3.5 dark:border-slate-700/60 dark:bg-slate-900/10 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Showing <span id="paginationInfoStart" class="font-medium text-slate-700 dark:text-slate-300">0</span> to
                    <span id="paginationInfoEnd" class="font-medium text-slate-700 dark:text-slate-300">0</span> of
                    <span id="paginationInfoTotal" class="font-medium text-slate-700 dark:text-slate-300">0</span> records
                </div>
                <div class="flex items-center justify-end gap-1.5" id="paginationControlsContainer"></div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl dark:bg-slate-800">
            <div class="mb-4 flex items-center gap-3">
                <div class="rounded-full bg-red-500/10 p-2"><i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i></div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Driver</h3>
            </div>
            <p class="mb-6 text-sm text-slate-600 dark:text-slate-400">Are you sure you want to remove this driver profile?</p>
            <div class="flex gap-3">
                <button type="button" id="closeDeleteModalBtn" class="flex-1 rounded-xl border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition-all hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="flex-1 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">Delete</button>
            </div>
        </div>
    </div>
</x-admin.layout>
