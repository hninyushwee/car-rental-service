<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <div id="successBox"
            class="mb-5 hidden rounded-xl border border-green-500/20 bg-green-500/10 p-4 text-sm text-green-600 dark:text-green-400">
            <div class="flex items-center justify-between">
                <span id="successText"></span>
                <button class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>
        <div id="errorBox"
            class="mb-5 hidden rounded-xl border border-red-500/20 bg-red-500/10 p-4 text-sm text-red-600 dark:text-red-400">
            <div class="flex items-center justify-between">
                <span id="errorText"></span>
                <button class="close-alert font-bold hover:opacity-70">&times;</button>
            </div>
        </div>

        <div
            class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1
                        class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
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

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4 mb-6">
            <div
                class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-cyan-500/10 p-2">
                        <i data-lucide="car" class="h-5 w-5 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Total Vehicles</p>
                        <p id="statTotal" class="text-xl font-bold text-slate-900 dark:text-white">0</p>
                    </div>
                </div>
            </div>
            <div
                class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-green-500/10 p-2">
                        <i data-lucide="check-circle" class="h-5 w-5 text-green-600 dark:text-green-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Available</p>
                        <p id="statAvailable" class="text-xl font-bold text-green-600 dark:text-green-400">0</p>
                    </div>
                </div>
            </div>
            <div
                class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-yellow-500/10 p-2">
                        <i data-lucide="clock" class="h-5 w-5 text-yellow-600 dark:text-yellow-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Rented</p>
                        <p id="statRented" class="text-xl font-bold text-yellow-600 dark:text-yellow-400">0</p>
                    </div>
                </div>
            </div>
            <div
                class="rounded-xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 p-4 shadow-sm">
                <div class="flex items-center gap-3">
                    <div class="rounded-lg bg-red-500/10 p-2">
                        <i data-lucide="wrench" class="h-5 w-5 text-red-600 dark:text-red-400"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Maintenance</p>
                        <p id="statMaintenance" class="text-xl font-bold text-red-600 dark:text-red-400">0</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="relative flex-1 max-w-md">
                <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-slate-400"></i>
                <input type="text" id="searchInput" placeholder="Search by category, brand, model, license..."
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
                <button id="refreshBtn" title="Reset and Reload Data"
                    class="rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm text-slate-700 dark:text-slate-300 transition-all hover:bg-slate-50 dark:hover:bg-slate-700 flex items-center justify-center gap-2">
                    <i data-lucide="refresh-cw" class="h-4 w-4"></i>
                    <span>Reload</span>
                </button>
            </div>
        </div>

        <div
            class="rounded-2xl border border-slate-200/60 dark:border-slate-700/60 bg-white/90 dark:bg-slate-800/90 shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 backdrop-blur-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr
                            class="border-b border-slate-200/60 dark:border-slate-700/60 bg-slate-50/50 dark:bg-slate-900/30">
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider w-12">
                                No</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Brand</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Model</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                License Plate</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Year</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Price/Day</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-3 text-right text-xs font-medium text-slate-500 dark:text-slate-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="vehiclesTableBody">
                        <tr>
                            <td colspan="9" class="px-4 py-12 text-center text-slate-400">Loading fleet
                                information...</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div
                class="border-t border-slate-200/60 dark:border-slate-700/60 px-4 py-3.5 bg-slate-50/30 dark:bg-slate-900/10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Showing <span id="paginationInfoStart"
                        class="font-medium text-slate-700 dark:text-slate-300">0</span> to
                    <span id="paginationInfoEnd" class="font-medium text-slate-700 dark:text-slate-300">0</span> of
                    <span id="paginationInfoTotal" class="font-medium text-slate-700 dark:text-slate-300">0</span>
                    records
                </div>
                <div class="flex items-center justify-end gap-1.5" id="paginationControlsContainer"></div>
            </div>
        </div>
    </div>

    <div id="deleteConfirmationModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50 backdrop-blur-sm">
        <div
            class="w-full max-w-md rounded-2xl bg-white dark:bg-slate-800 p-6 shadow-2xl animate-in fade-in zoom-in duration-200">
            <div class="flex items-center gap-3 mb-4">
                <div class="rounded-full bg-red-500/10 p-2">
                    <i data-lucide="alert-triangle" class="h-6 w-6 text-red-600 dark:text-red-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Vehicle</h3>
            </div>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Are you sure you want to delete this vehicle
                from inventory? This action cannot be undone.</p>
            <div class="flex gap-3">
                <button id="closeDeleteModalBtn"
                    class="flex-1 rounded-xl border border-slate-300 dark:border-slate-600 px-4 py-2.5 text-sm font-medium text-slate-700 dark:text-slate-300 transition-all hover:bg-slate-50 dark:hover:bg-slate-700">
                    Cancel
                </button>
                <button id="confirmDeleteBtn"
                    class="flex-1 rounded-xl bg-gradient-to-r from-red-500 to-red-600 px-4 py-2.5 text-sm font-medium text-white shadow-lg transition-all hover:shadow-xl">
                    Delete
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const $tableBody = $('#vehiclesTableBody');
                const $searchInput = $('#searchInput');
                const $statusFilter = $('#statusFilter');
                const $refreshBtn = $('#refreshBtn');

                const $statTotal = $('#statTotal');
                const $statAvailable = $('#statAvailable');
                const $statRented = $('#statRented');
                const $statMaintenance = $('#statMaintenance');

                const $successBox = $('#successBox');
                const $successText = $('#successText');
                const $errorBox = $('#errorBox');
                const $errorText = $('#errorText');

                const $deleteModal = $('#deleteConfirmationModal');
                const $confirmDeleteBtn = $('#confirmDeleteBtn');
                const $closeDeleteModalBtn = $('#closeDeleteModalBtn');

                let localVehiclesCache = [];
                let filteredVehiclesCache = [];
                let targetDeleteId = null;

                let currentPage = 1;
                const recordsPerPage = 5;

                const getHeaders = () => ({
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                });

                function handleAjaxError(xhr, fallbackMessage) {
                    if (xhr.status === 401) {
                        window.location.href = "{{ url('/login') }}";
                    } else {
                        const msg = xhr.responseJSON?.message || fallbackMessage;
                        showAlert('error', msg);
                    }
                }

                function refreshIcons() {
                    if (window.lucide && typeof window.lucide.createIcons === 'function') {
                        window.lucide.createIcons();
                    }
                }

                function showAlert(type, message) {
                    $successBox.addClass('hidden');
                    $errorBox.addClass('hidden');

                    if (type === 'success') {
                        $successText.text(message);
                        $successBox.removeClass('hidden');
                    } else if (type === 'error') {
                        $errorText.text(message);
                        $errorBox.removeClass('hidden');
                    }
                    refreshIcons();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }

                $('.close-alert').on('click', function() {
                    $(this).closest('.rounded-xl').addClass('hidden');
                });

                function filterTableData() {
                    const searchVal = $searchInput.val().toLowerCase().trim();
                    const statusVal = $statusFilter.val().toLowerCase();

                    filteredVehiclesCache = localVehiclesCache.filter(vehicle => {
                        const brandName = (vehicle.brand?.name || '').toLowerCase();
                        const modelName = (vehicle.model || '').toLowerCase();
                        const licensePlate = (vehicle.license_plate || '').toLowerCase();
                        const categoryName = (vehicle.category?.name || '').toLowerCase();
                        const statusText = (vehicle.status || '').toLowerCase();

                        const matchesSearch = brandName.includes(searchVal) ||
                            modelName.includes(searchVal) ||
                            licensePlate.includes(searchVal) ||
                            categoryName.includes(searchVal);

                        const matchesStatus = statusVal === '' || statusText === statusVal;

                        return matchesSearch && matchesStatus;
                    });

                    currentPage = 1;
                    renderTablePage();
                }

                function renderTablePage() {
                    let rows = '';
                    const totalRecords = filteredVehiclesCache.length;

                    if (totalRecords === 0) {
                        rows = `
                            <tr>
                                <td colspan="9" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="search-x" class="h-6 w-6 text-slate-300 dark:text-slate-600"></i>
                                        <span>No vehicles match your active filtering queries.</span>
                                    </div>
                                </td>
                            </tr>`;
                        $tableBody.html(rows);
                        updatePaginationFooter(0, 0, 0);
                        refreshIcons();
                        return;
                    }

                    const totalPages = Math.ceil(totalRecords / recordsPerPage);
                    if (currentPage > totalPages) currentPage = totalPages;
                    if (currentPage < 1) currentPage = 1;

                    const startOffset = (currentPage - 1) * recordsPerPage;
                    const endOffset = Math.min(startOffset + recordsPerPage, totalRecords);
                    const pageItems = filteredVehiclesCache.slice(startOffset, endOffset);

                    pageItems.forEach((vehicle, index) => {
                        const sequentialNo = startOffset + index + 1;
                        const badgeColor = vehicle.status === 'available' ?
                            'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400' :
                            vehicle.status === 'rented' ?
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400' :
                            'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400';

                        const dotColor = vehicle.status === 'available' ? 'bg-green-500' :
                            vehicle.status === 'rented' ? 'bg-yellow-500' : 'bg-red-500';

                        const formattedPrice = new Intl.NumberFormat('en-US', {
                            style: 'currency',
                            currency: 'USD'
                        }).format(vehicle.price_per_day);
                        const capitalizeStatus = vehicle.status.charAt(0).toUpperCase() + vehicle.status.slice(
                            1);

                        rows += `
                            <tr class="border-b border-slate-200/60 dark:border-slate-700/60 hover:bg-slate-50/50 dark:hover:bg-slate-700/30 transition-colors">
                                <td class="px-4 py-3 font-medium text-slate-400 dark:text-slate-500">${sequentialNo}</td>
                                <td class="px-4 py-3 font-semibold text-slate-900 dark:text-white">${vehicle.brand?.name || 'Unknown'}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-300 font-medium">${vehicle.model}</td>
                                <td class="px-4 py-3 font-mono text-xs tracking-wider text-slate-600 dark:text-slate-400 bg-slate-50/30 dark:bg-slate-900/10 rounded px-1.5 py-0.5">${vehicle.license_plate}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400">${vehicle.category?.name || 'N/A'}</td>
                                <td class="px-4 py-3 text-slate-600 dark:text-slate-400 font-medium">${vehicle.year}</td>
                                <td class="px-4 py-3 font-bold text-slate-900 dark:text-white">${formattedPrice}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium ${badgeColor}">
                                        <span class="inline-block h-1.5 w-1.5 rounded-full ${dotColor}"></span>
                                        ${capitalizeStatus}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="/admin/vehicles/${vehicle.id}" data-id="${vehicle.id}" class="view-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-slate-600 hover:border-slate-500 hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-900" title="View Details">
                                            <i class="h-4 w-4" data-lucide="eye"></i>
                                        </a>
                                        
                                        <a href="/admin/vehicles/${vehicle.id}/edit" data-id="${vehicle.id}" data-model="${vehicle.model}" class="edit-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-cyan-600 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900" title="Edit">
                                            <i class="h-4 w-4" data-lucide="pencil"></i>
                                        </a>
                                        
                                        <button data-id="${vehicle.id}" class="delete-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900" title="Delete">
                                            <i class="h-4 w-4" data-lucide="trash-2"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>`;
                    });

                    $tableBody.html(rows);
                    updatePaginationFooter(startOffset + 1, endOffset, totalRecords);
                    refreshIcons();
                }

                function updatePaginationFooter(start, end, total) {
                    $('#paginationInfoStart').text(start);
                    $('#paginationInfoEnd').text(end);
                    $('#paginationInfoTotal').text(total);

                    const totalPages = Math.ceil(total / recordsPerPage);
                    const $container = $('#paginationControlsContainer');
                    $container.empty();

                    if (totalPages <= 1) return;

                    $container.append(`
                        <button data-page="${currentPage - 1}" ${currentPage === 1 ? 'disabled' : ''} 
                            class="pagination-trigger p-2 rounded-lg border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-40 disabled:hover:bg-transparent transition-colors">
                            <i data-lucide="chevron-left" class="h-4 w-4"></i>
                        </button>
                    `);

                    for (let i = 1; i <= totalPages; i++) {
                        const activeStyles = i === currentPage ?
                            'bg-gradient-to-r from-cyan-500 to-blue-600 text-white border-transparent' :
                            'border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300';

                        $container.append(`
                            <button data-page="${i}" class="pagination-trigger px-3 py-1.5 rounded-lg border text-xs font-semibold shadow-sm transition-all ${activeStyles}">
                                ${i}
                            </button>
                        `);
                    }

                    $container.append(`
                        <button data-page="${currentPage + 1}" ${currentPage === totalPages ? 'disabled' : ''} 
                            class="pagination-trigger p-2 rounded-lg border border-slate-300 dark:border-slate-600 hover:bg-slate-50 dark:hover:bg-slate-700 disabled:opacity-40 disabled:hover:bg-transparent transition-colors">
                            <i data-lucide="chevron-right" class="h-4 w-4"></i>
                        </button>
                    `);
                }

                $(document).on('click', '.pagination-trigger', function() {
                    if ($(this).prop('disabled')) return;
                    currentPage = parseInt($(this).attr('data-page'));
                    renderTablePage();
                });

                $searchInput.on('keyup', filterTableData);
                $statusFilter.on('change', filterTableData);

                $refreshBtn.on('click', function() {
                    $searchInput.val('');
                    $statusFilter.val('');
                    loadVehicles();
                });

                function loadVehicles() {
                    $.ajax({
                        url: "{{ url('/api/admin/vehicles') }}",
                        method: 'GET',
                        headers: getHeaders(),
                        dataType: 'json',
                        success: function(result) {
                            localVehiclesCache = result.vehicles || result.data || [];
                            const stats = result.stats || calculateFallbackStats(localVehiclesCache);

                            updateDashboardStats(stats);
                            filteredVehiclesCache = [...localVehiclesCache];
                            renderTablePage();
                        },
                        error: function(xhr) {
                            $tableBody.html(
                                `<tr><td colspan="9" class="px-4 py-12 text-center text-red-500 font-medium">Failed to update runtime inventory parameters.</td></tr>`
                                );
                            handleAjaxError(xhr, 'Failed to fetch tracking details.');
                        }
                    });
                }

                function updateDashboardStats(stats) {
                    $statTotal.text(stats.total ?? 0);
                    $statAvailable.text(stats.available ?? 0);
                    $statRented.text(stats.rented ?? 0);
                    $statMaintenance.text(stats.maintenance ?? 0);
                }

                function calculateFallbackStats(list) {
                    return {
                        total: list.length,
                        available: list.filter(v => v.status === 'available').length,
                        rented: list.filter(v => v.status === 'rented').length,
                        maintenance: list.filter(v => v.status === 'maintenance').length
                    };
                }

                $tableBody.on('click', '.delete-btn', function() {
                    targetDeleteId = $(this).attr('data-id');
                    $deleteModal.removeClass('hidden').addClass('flex');
                    document.body.style.overflow = 'hidden';
                });

                function hideDeleteModal() {
                    $deleteModal.addClass('hidden').removeClass('flex');
                    document.body.style.overflow = '';
                    targetDeleteId = null;
                }

                $closeDeleteModalBtn.on('click', hideDeleteModal);

                $deleteModal.on('click', function(e) {
                    if (e.target === this) hideDeleteModal();
                });

                $confirmDeleteBtn.on('click', function() {
                    if (!targetDeleteId) return;

                    $.ajax({
                        url: `{{ url('/api/admin/vehicles') }}/${targetDeleteId}`,
                        method: 'DELETE',
                        headers: getHeaders(),
                        dataType: 'json',
                        success: function(response) {
                            hideDeleteModal();
                            loadVehicles();
                            showAlert('success', response.message ||
                                'Vehicle registry index wiped out successfully.');
                        },
                        error: function(xhr) {
                            hideDeleteModal();
                            handleAjaxError(xhr,
                                'Error context execution failure on downstream collection.');
                        }
                    });
                });

                loadVehicles();
            });
        </script>
    @endpush
</x-admin.layout>
