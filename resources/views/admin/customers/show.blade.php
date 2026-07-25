<x-admin.layout>
    <div id="customerDetailsContainer" data-page="admin-customer-show" data-id="{{ $customerId }}"
        data-api-base="{{ url('/api/admin/users') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">

        <div id="loadingState" class="py-20">
            <div class="mb-8">
                <div class="skeleton h-3 w-24 mb-3"></div>
                <div class="skeleton h-7 w-56 mb-2"></div>
                <div class="skeleton h-4 w-40"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="skeleton h-5 w-40 mb-4"></div>
                        <div class="space-y-3">
                            <div class="skeleton h-5 w-full"></div>
                            <div class="skeleton h-5 w-3/4"></div>
                            <div class="skeleton h-5 w-1/2"></div>
                        </div>
                    </div>
                </div>
                <aside class="xl:col-span-1">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="skeleton h-5 w-24 mb-4"></div>
                        <div class="space-y-3">
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div id="detailsContent" class="hidden">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('admin.customers.index') }}"
                        class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                        Back to customers
                    </a>
                    <h1 id="customerName" class="text-2xl font-bold text-slate-900 dark:text-white">Loading...</h1>
                    <p id="customerEmail" class="mt-1 text-slate-600 dark:text-slate-400"></p>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 space-y-6">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Account Information</h3>
                        <div id="infoContainer" class="space-y-3"></div>
                    </div>
                </div>

                <aside class="xl:col-span-1">
                    <div class="sticky top-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h2 class="text-lg font-bold text-slate-900 dark:text-white mb-4">Activity</h2>
                        <div id="activityContainer" class="space-y-3">
                            <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-900">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Bookings</span>
                                <span id="activityBookings" class="text-sm font-bold text-slate-900 dark:text-white">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-900">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Payments</span>
                                <span id="activityPayments" class="text-sm font-bold text-slate-900 dark:text-white">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-900">
                                <span class="text-sm text-slate-600 dark:text-slate-400">Inquiries</span>
                                <span id="activityInquiries" class="text-sm font-bold text-slate-900 dark:text-white">0</span>
                            </div>
                            <div class="flex items-center justify-between rounded-lg bg-slate-50 p-3 dark:bg-slate-900">
                                <span class="text-sm text-slate-600 dark:text-slate-400">License Requests</span>
                                <span id="activityLicenses" class="text-sm font-bold text-slate-900 dark:text-white">0</span>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-admin.layout>
