<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Vehicles
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="truck" class="h-4 w-4"></i>
                        Manage your fleet inventory
                    </p>
                </div>
                <a href="{{ route('admin.vehicles.create') }}"
                    class="group flex items-center gap-2 rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl hover:scale-[1.02]">
                    <i data-lucide="plus" class="h-5 w-5 transition-transform group-hover:rotate-90"></i>
                    Add New Vehicle
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <div class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-cyan-500/10 p-2">
                        <i data-lucide="car" class="h-5 w-5 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Vehicles</p>
                        <p class="text-xl font-bold text-slate-900 dark:text-white">{{ $totalVehicles ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-green-500/10 p-2">
                        <i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Available</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $availableCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-yellow-500/10 p-2">
                        <i data-lucide="clock" class="h-5 w-5 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Rented</p>
                        <p class="text-xl font-bold text-yellow-600 dark:text-yellow-400">{{ $rentedCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
            <div class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-red-500/10 p-2">
                        <i data-lucide="wrench" class="h-5 w-5 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Maintenance</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $maintenanceCount ?? 0 }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative flex-1 max-w-md">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by model, brand, or license plate..."
                    class="w-full rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 pl-9 pr-4 py-2.5 text-sm transition-all hover:border-slate-400 dark:hover:border-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:text-white placeholder:text-slate-400 dark:placeholder:text-slate-500">
            </div>
            <div class="flex gap-2">
                <select id="statusFilter" 
                    class="rounded-xl border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 px-4 py-2.5 text-sm transition-all hover:border-slate-400 dark:hover:border-slate-500 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/30 dark:text-white">
                    <option value="">All Status</option>
                    <option value="available">Available</option>
                    <option value="rented">Rented</option>
                    <option value="maintenance">Maintenance</option>
                </select>
                <button onclick="window.location.reload()" 
                    class="rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                </button>
            </div>
        </div>

        <!-- Vehicles Table -->
        <div class="rounded-2xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200/60 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Vehicle</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">License Plate</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Year</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Price/Day</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="vehiclesTableBody">
                        @forelse($vehicles ?? [] as $vehicle)
                            <tr class="border-b border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-3">
                                        @if($vehicle->image)
                                            <img src="{{ asset('storage/' . $vehicle->image) }}" alt="{{ $vehicle->model }}" 
                                                class="h-10 w-10 rounded-lg object-cover">
                                        @else
                                            <div class="h-10 w-10 rounded-lg bg-gradient-to-br from-cyan-500/20 to-blue-600/20 flex items-center justify-center">
                                                <i data-lucide="car" class="h-5 w-5 text-cyan-600 dark:text-cyan-400"></i>
                                    </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-slate-900 dark:text-white">{{ $vehicle->brand?->name ?? 'Unknown' }}</p>
                                            <p class="text-xs text-slate-500 dark:text-slate-400">{{ $vehicle->model }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 font-mono text-sm text-slate-700 dark:text-slate-300">{{ $vehicle->license_plate }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300">{{ $vehicle->category?->name ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300">{{ $vehicle->year }}</td>
                                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">${{ number_format($vehicle->price_per_day, 2) }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium
                                        @if($vehicle->status == 'available') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($vehicle->status == 'rented') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @else bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400 @endif">
                                        <span class="inline-block h-1.5 w-1.5 rounded-full
                                            @if($vehicle->status == 'available') bg-green-500
                                            @elseif($vehicle->status == 'rented') bg-yellow-500
                                            @else bg-red-500 @endif">
                                        </span>
                                        {{ ucfirst($vehicle->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('admin.vehicles.edit', $vehicle) }}" 
                                            class="rounded-lg p-1.5 text-slate-500 hover:bg-cyan-500/10 hover:text-cyan-600 dark:text-slate-400 dark:hover:text-cyan-400 transition-colors"
                                            title="Edit">
                                            <i data-lucide="edit-2" class="h-4 w-4"></i>
                                        </a>
                                        <button onclick="confirmDelete('{{ $vehicle->id }}')" 
                                            class="rounded-lg p-1.5 text-slate-500 hover:bg-red-500/10 hover:text-red-600 dark:text-slate-400 dark:hover:text-red-400 transition-colors"
                                            title="Delete">
                                            <i data-lucide="trash-2" class="h-4 w-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-12 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="rounded-full bg-slate-100 dark:bg-slate-700 p-4">
                                            <i data-lucide="inbox" class="h-8 w-8 text-slate-400 dark:text-slate-500"></i>
                                        </div>
                                        <p class="text-slate-500 dark:text-slate-400">No vehicles found</p>
                                        <a href="{{ route('admin.vehicles.create') }}" 
                                            class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 text-sm font-medium text-white shadow-md hover:shadow-lg transition-all">
                                            <i data-lucide="plus" class="h-4 w-4"></i>
                                            Add your first vehicle
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if(isset($vehicles) && method_exists($vehicles, 'links'))
                <div class="border-t border-slate-200/60 dark:border-slate-700/60 px-4 py-3">
                    {{ $vehicles->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div class="w-full max-w-md rounded-2xl bg-white dark:bg-slate-800 p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="flex items-center gap-3 mb-4">
                <div class="rounded-full bg-red-500/10 p-2">
                    <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Vehicle</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Are you sure you want to delete this vehicle? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button onclick="closeDeleteModal()" 
                    class="flex-1 rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                    Cancel
                </button>
                <form id="deleteForm" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" 
                        class="w-full rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">
                        Delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function confirmDelete(vehicleId) {
                const modal = document.getElementById('deleteModal');
                const form = document.getElementById('deleteForm');
                form.action = `/admin/vehicles/${vehicleId}`;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeDeleteModal() {
                const modal = document.getElementById('deleteModal');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = '';
            }

            // Close modal on backdrop click
            document.getElementById('deleteModal')?.addEventListener('click', function(e) {
                if (e.target === this) {
                    closeDeleteModal();
                }
            });

            // Live search functionality
            document.getElementById('searchInput')?.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const rows = document.querySelectorAll('#vehiclesTableBody tr');
                
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Status filter
            document.getElementById('statusFilter')?.addEventListener('change', function() {
                const status = this.value.toLowerCase();
                const rows = document.querySelectorAll('#vehiclesTableBody tr');
                
                rows.forEach(row => {
                    if (status === '') {
                        row.style.display = '';
                        return;
                    }
                    const statusCell = row.querySelector('td:nth-child(6)');
                    if (statusCell) {
                        const statusText = statusCell.textContent.toLowerCase().trim();
                        row.style.display = statusText.includes(status) ? '' : 'none';
                    }
                });
            });
        </script>
    @endpush
</x-admin.layout>