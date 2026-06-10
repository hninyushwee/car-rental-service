<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">All Vehicles</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">Manage your vehicle fleet</p>
            </div>
            <a href="/admin/vehicles/add" class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                <i data-lucide="plus" class="h-5 w-5"></i>
                Add Vehicle
            </a>
        </div>

        <!-- Filters and Search -->
        <div class="mb-6 grid grid-cols-1 gap-4 md:grid-cols-4">
            <div>
                <input type="search" placeholder="Search vehicles..." class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-800 dark:text-white">
            </div>
            <select class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                <option>All Categories</option>
                <option>Economy</option>
                <option>Luxury</option>
                <option>SUV</option>
            </select>
            <select class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                <option>All Brands</option>
                <option>BMW</option>
                <option>Lexus</option>
                <option>Mercedes</option>
            </select>
            <select class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm dark:border-slate-600 dark:bg-slate-800 dark:text-white">
                <option>All Status</option>
                <option>Available</option>
                <option>In Use</option>
                <option>Maintenance</option>
            </select>
        </div>

        <!-- Vehicles Grid -->
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">
            <!-- Vehicle Card -->
            <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="aspect-video bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center">
                    <i data-lucide="car" class="h-16 w-16 text-white opacity-20"></i>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">BMW 7 Series</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Luxury Sedan</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-2 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300">
                            <span class="h-2 w-2 rounded-full bg-green-600"></span>
                            Available
                        </span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-200 pt-3 dark:border-slate-700">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Year</p>
                            <p class="font-semibold text-slate-900 dark:text-white">2024</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Plate</p>
                            <p class="font-semibold text-slate-900 dark:text-white">BM-2048</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Rate/Day</p>
                            <p class="font-semibold text-slate-900 dark:text-white">$150</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Bookings</p>
                            <p class="font-semibold text-slate-900 dark:text-white">48</p>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="button" class="flex-1 rounded-lg border border-slate-300 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            Edit
                        </button>
                        <button type="button" class="flex-1 rounded-lg bg-slate-100 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                            Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vehicle Card -->
            <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="aspect-video bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center">
                    <i data-lucide="car" class="h-16 w-16 text-white opacity-20"></i>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Lexus RX</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Premium SUV</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-cyan-100 px-2 py-1 text-xs font-medium text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300">
                            <span class="h-2 w-2 rounded-full bg-cyan-600"></span>
                            In Use
                        </span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-200 pt-3 dark:border-slate-700">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Year</p>
                            <p class="font-semibold text-slate-900 dark:text-white">2023</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Plate</p>
                            <p class="font-semibold text-slate-900 dark:text-white">LX-1524</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Rate/Day</p>
                            <p class="font-semibold text-slate-900 dark:text-white">$120</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Bookings</p>
                            <p class="font-semibold text-slate-900 dark:text-white">42</p>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="button" class="flex-1 rounded-lg border border-slate-300 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            Edit
                        </button>
                        <button type="button" class="flex-1 rounded-lg bg-slate-100 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                            Details
                        </button>
                    </div>
                </div>
            </div>

            <!-- Vehicle Card -->
            <div class="rounded-xl border border-slate-200 bg-white overflow-hidden shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="aspect-video bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                    <i data-lucide="car" class="h-16 w-16 text-white opacity-20"></i>
                </div>
                <div class="p-4">
                    <div class="flex items-start justify-between">
                        <div>
                            <h3 class="font-bold text-slate-900 dark:text-white">Mercedes S-Class</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Executive Sedan</p>
                        </div>
                        <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-2 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300">
                            <span class="h-2 w-2 rounded-full bg-yellow-600"></span>
                            Maintenance
                        </span>
                    </div>
                    <div class="mt-4 grid grid-cols-2 gap-2 border-t border-slate-200 pt-3 dark:border-slate-700">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Year</p>
                            <p class="font-semibold text-slate-900 dark:text-white">2024</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Plate</p>
                            <p class="font-semibold text-slate-900 dark:text-white">MB-3842</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Rate/Day</p>
                            <p class="font-semibold text-slate-900 dark:text-white">$180</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Bookings</p>
                            <p class="font-semibold text-slate-900 dark:text-white">38</p>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <button type="button" class="flex-1 rounded-lg border border-slate-300 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            Edit
                        </button>
                        <button type="button" class="flex-1 rounded-lg bg-slate-100 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-200 dark:bg-slate-700 dark:text-slate-300 dark:hover:bg-slate-600">
                            Details
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
