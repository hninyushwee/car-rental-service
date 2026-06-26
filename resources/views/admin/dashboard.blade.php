<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Dashboard</h1>
            <p class="mt-1 text-slate-600 dark:text-slate-400">Welcome back, Sarah! Here's what's happening with your business today.</p>
        </div>

        <!-- Quick Stats -->
        <div class="mb-8 grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
            <!-- Total Vehicles -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Vehicles</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">142</p>
                        <p class="mt-2 flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                            <i data-lucide="arrow-up" class="h-4 w-4"></i>
                            <span>2.5% from last month</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-cyan-100 p-3 dark:bg-cyan-950">
                        <i data-lucide="car" class="h-6 w-6 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                </div>
            </div>

            <!-- Total Drivers -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Total Drivers</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">58</p>
                        <p class="mt-2 flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                            <i data-lucide="arrow-up" class="h-4 w-4"></i>
                            <span>1.2% from last month</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-blue-100 p-3 dark:bg-blue-950">
                        <i data-lucide="users" class="h-6 w-6 text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>

            <!-- Active Bookings -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Active Bookings</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">34</p>
                        <p class="mt-2 flex items-center gap-1 text-xs font-medium text-yellow-600 dark:text-yellow-400">
                            <i data-lucide="arrow-down" class="h-4 w-4"></i>
                            <span>0.5% from yesterday</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-amber-100 p-3 dark:bg-amber-950">
                        <i data-lucide="calendar" class="h-6 w-6 text-amber-600 dark:text-amber-400"></i>
                    </div>
                </div>
            </div>

            <!-- Monthly Revenue -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400">Monthly Revenue</p>
                        <p class="mt-2 text-3xl font-bold text-slate-900 dark:text-white">$45,250</p>
                        <p class="mt-2 flex items-center gap-1 text-xs font-medium text-green-600 dark:text-green-400">
                            <i data-lucide="arrow-up" class="h-4 w-4"></i>
                            <span>12.8% from last month</span>
                        </p>
                    </div>
                    <div class="rounded-lg bg-green-100 p-3 dark:bg-green-950">
                        <i data-lucide="dollar-sign" class="h-6 w-6 text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-3">
            <!-- Revenue Chart -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800 lg:col-span-2">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Revenue Trend</h2>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>

            <!-- Booking Status Distribution -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Booking Status</h2>
                <div class="chart-container">
                    <canvas id="bookingStatusChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Secondary Charts -->
        <div class="mb-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
            <!-- Vehicle Utilization -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Vehicle Utilization</h2>
                <div class="chart-container">
                    <canvas id="utilizationChart"></canvas>
                </div>
            </div>

            <!-- Top Vehicles -->
            <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <h2 class="mb-6 text-lg font-bold text-slate-900 dark:text-white">Top Booked Vehicles</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center">
                                <i data-lucide="car" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">BMW 7 Series</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">48 bookings</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-900 dark:text-white">85%</p>
                            <div class="mt-1 h-1.5 w-24 rounded-full bg-slate-200 dark:bg-slate-700">
                                <div class="h-full w-4/5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-amber-400 to-orange-600 flex items-center justify-center">
                                <i data-lucide="car" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">Lexus RX</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">42 bookings</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-900 dark:text-white">75%</p>
                            <div class="mt-1 h-1.5 w-24 rounded-full bg-slate-200 dark:bg-slate-700">
                                <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-amber-500 to-orange-600"></div>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between rounded-lg border border-slate-200 bg-slate-50 p-4 dark:border-slate-700 dark:bg-slate-900">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-lg bg-gradient-to-br from-purple-400 to-pink-600 flex items-center justify-center">
                                <i data-lucide="car" class="h-6 w-6 text-white"></i>
                            </div>
                            <div>
                                <p class="font-medium text-slate-900 dark:text-white">Mercedes S-Class</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">38 bookings</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-slate-900 dark:text-white">68%</p>
                            <div class="mt-1 h-1.5 w-24 rounded-full bg-slate-200 dark:bg-slate-700">
                                <div class="h-full w-2/3 rounded-full bg-gradient-to-r from-purple-500 to-pink-600"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Bookings Table -->
        <div class="rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
            <div class="border-b border-slate-200 px-6 py-4 dark:border-slate-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Bookings</h2>
                    <a href="#" class="text-sm font-medium text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">View All</a>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-slate-200 bg-slate-50 dark:border-slate-700 dark:bg-slate-900">
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Booking ID</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Vehicle</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Pickup Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Status</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-slate-600 dark:text-slate-400">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700">
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">SL-2048</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Ava Thompson</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">BMW 7 Series</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">June 15, 2026</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300">
                                    <span class="h-2 w-2 rounded-full bg-green-600 dark:bg-green-400"></span>
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">$450.00</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="edit" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">SL-2047</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">James Chen</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Lexus RX</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">June 14, 2026</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-cyan-100 px-3 py-1 text-xs font-medium text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300">
                                    <span class="h-2 w-2 rounded-full bg-cyan-600 dark:bg-cyan-400"></span>
                                    Confirmed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">$380.00</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="edit" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">SL-2046</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Maria Rodriguez</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Mercedes S-Class</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">June 13, 2026</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300">
                                    <span class="h-2 w-2 rounded-full bg-yellow-600 dark:bg-yellow-400"></span>
                                    Pending
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">$520.00</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="edit" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">SL-2045</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">David Miller</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Audi A8</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">June 12, 2026</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                                    <span class="h-2 w-2 rounded-full bg-slate-600 dark:bg-slate-400"></span>
                                    Completed
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">$420.00</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="edit" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-900">
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">SL-2044</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Emily Wilson</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">Porsche 911</td>
                            <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">June 11, 2026</td>
                            <td class="px-6 py-4 text-sm">
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-950 dark:text-red-300">
                                    <span class="h-2 w-2 rounded-full bg-red-600 dark:bg-red-400"></span>
                                    Cancelled
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-slate-900 dark:text-white">$580.00</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex items-center gap-2">
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="eye" class="h-4 w-4"></i>
                                    </button>
                                    <button type="button" class="p-1.5 text-slate-600 hover:bg-slate-100 rounded-lg dark:text-slate-400 dark:hover:bg-slate-700">
                                        <i data-lucide="edit" class="h-4 w-4"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{
                    label: 'Revenue',
                    data: [28000, 32000, 26500, 35000, 40200, 45250],
                    borderColor: 'rgb(6, 182, 212)',
                    backgroundColor: 'rgba(6, 182, 212, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: 'rgb(6, 182, 212)',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 50000,
                        ticks: {
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

        // Booking Status Chart
        const statusCtx = document.getElementById('bookingStatusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Confirmed', 'Pending', 'Completed', 'Cancelled'],
                datasets: [{
                    data: [34, 28, 12, 48, 8],
                    backgroundColor: [
                        'rgb(34, 197, 94)',
                        'rgb(6, 182, 212)',
                        'rgb(245, 158, 11)',
                        'rgb(107, 114, 128)',
                        'rgb(239, 68, 68)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                }
            }
        });

        // Vehicle Utilization Chart
        const utilizationCtx = document.getElementById('utilizationChart').getContext('2d');
        new Chart(utilizationCtx, {
            type: 'bar',
            data: {
                labels: ['BMW 7', 'Lexus RX', 'Mercedes S', 'Audi A8', 'Porsche 911'],
                datasets: [{
                    label: 'Utilization %',
                    data: [85, 75, 68, 72, 58],
                    backgroundColor: [
                        'rgba(6, 182, 212, 0.8)',
                        'rgba(59, 130, 246, 0.8)',
                        'rgba(168, 85, 247, 0.8)',
                        'rgba(34, 197, 94, 0.8)',
                        'rgba(245, 158, 11, 0.8)'
                    ],
                    borderRadius: 8,
                    borderSkipped: false
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    x: {
                        max: 100,
                        ticks: {
                            callback: function(value) {
                                return value + '%';
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin.layout>
