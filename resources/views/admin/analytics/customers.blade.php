@php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
@endphp

<x-admin.layout>
    <div data-page="admin-analytics-customers" data-api-url="{{ url('/api/admin/analytics/customers') }}" data-login-url="{{ route('login') }}" data-admin-url="{{ $adminUrl }}" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">Customer Analytics</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="bar-chart-3" class="h-3 w-3"></i>
                        Track customer growth and engagement.
                    </p>
                </div>
            </div>
        </div>

        <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-cyan-500/10 p-1.5">
                        <i data-lucide="users-round" class="h-3.5 w-3.5 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Customers</p>
                        <p id="statTotal" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-blue-500/10 p-1.5">
                        <i data-lucide="message-circle" class="h-3.5 w-3.5 text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">Total Inquiries</p>
                        <p id="statInquiries" class="font-bold text-slate-900 text-lg dark:text-white">--</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-3 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="flex items-center gap-2">
                    <div class="rounded-lg bg-emerald-500/10 p-1.5">
                        <i data-lucide="user-plus" class="h-3.5 w-3.5 text-emerald-600 dark:text-emerald-400"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 dark:text-slate-400">This Month New</p>
                        <p id="statMonth" class="font-bold text-lg text-emerald-600 dark:text-emerald-400">--</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-1">
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Customer Growth</h2>
                <div class="chart-container">
                    <canvas id="trendChart"></canvas>
                </div>
            </div>
        </div>

        <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white/90 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
            <div class="border-b border-slate-200/60 px-6 py-4 dark:border-slate-700/60">
                <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Customers</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 bg-slate-50/50 dark:border-slate-700/60 dark:bg-slate-900/30">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Phone</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Joined</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Bookings</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-500 dark:text-slate-400">Inquiries</th>
                        </tr>
                    </thead>
                    <tbody id="recentCustomersBody" class="divide-y divide-slate-200/60 dark:divide-slate-700/60">
                        <tr><td colspan="6" class="px-6 py-8 text-center text-sm text-slate-500 dark:text-slate-400">Loading...</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin.layout>
