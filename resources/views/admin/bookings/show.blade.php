@php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
@endphp

<x-admin.layout>
    <div data-page="admin-booking-show" data-api-base="{{ url('/api/admin/bookings') }}" data-admin-url="{{ $adminUrl }}" class="p-4 sm:p-6 md:p-8">
        <div id="loadingState" class="py-20">
            <!-- Skeleton: Title row -->
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <div class="skeleton h-3 w-16 mb-3"></div>
                    <div class="skeleton h-7 w-64 mb-2"></div>
                    <div class="skeleton h-4 w-40"></div>
                </div>
                <div class="skeleton h-10 w-32 rounded-lg"></div>
            </div>
            <!-- Skeleton: Info cards -->
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3 mb-6">
                <div class="rounded-xl border border-slate-200/60 bg-white/90 p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                    <div class="skeleton h-4 w-24 mb-4"></div>
                    <div class="space-y-3">
                        <div class="skeleton h-5 w-48"></div>
                        <div class="skeleton h-5 w-36"></div>
                        <div class="skeleton h-5 w-40"></div>
                        <div class="skeleton h-5 w-32"></div>
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200/60 bg-white/90 p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                    <div class="skeleton h-4 w-20 mb-4"></div>
                    <div class="space-y-3">
                        <div class="skeleton h-5 w-44"></div>
                        <div class="skeleton h-5 w-32"></div>
                        <div class="skeleton h-5 w-52"></div>
                        <div class="skeleton h-5 w-36"></div>
                    </div>
                </div>
                <div class="rounded-xl border border-slate-200/60 bg-white/90 p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                    <div class="skeleton h-4 w-20 mb-4"></div>
                    <div class="space-y-3">
                        <div class="skeleton h-5 w-36"></div>
                        <div class="skeleton h-5 w-48"></div>
                        <div class="skeleton h-5 w-28"></div>
                        <div class="skeleton h-5 w-44"></div>
                    </div>
                </div>
            </div>
            <!-- Skeleton: Items sections -->
            <div class="rounded-xl border border-slate-200/60 bg-white/90 p-5 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                <div class="skeleton h-4 w-32 mb-4"></div>
                <div class="space-y-3">
                    <div class="skeleton h-14 w-full"></div>
                    <div class="skeleton h-14 w-full"></div>
                    <div class="skeleton h-14 w-full"></div>
                </div>
            </div>
        </div>
        <div id="bookingContent" class="hidden"></div>
        <div id="errorState" class="hidden py-20 text-center text-red-500 dark:text-red-400">
            <p id="errorMessage">Failed to load booking.</p>
            <button type="button" onclick="location.reload()" class="mt-4 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-medium text-black">Retry</button>
        </div>
    </div>
</x-admin.layout>
