@php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
@endphp

<x-admin.layout>
    <div data-page="admin-booking-show" data-api-base="{{ url('/api/admin/bookings') }}" data-admin-url="{{ $adminUrl }}" class="p-4 sm:p-6 md:p-8">
        <div id="loadingState" class="flex items-center justify-center py-20">
            <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                <svg class="h-6 w-6 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Loading booking details...
            </div>
        </div>
        <div id="bookingContent" class="hidden"></div>
        <div id="errorState" class="hidden py-20 text-center text-red-500 dark:text-red-400">
            <p id="errorMessage">Failed to load booking.</p>
            <button type="button" onclick="location.reload()" class="mt-4 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-medium text-black">Retry</button>
        </div>
    </div>
</x-admin.layout>
