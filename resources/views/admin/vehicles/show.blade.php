<x-admin.layout>
    <div id="vehicleDetailsContainer" data-id="{{ $vehicleId }}" class="p-4 sm:p-6 md:p-8">
        
        <div id="loadingState" class="flex flex-col items-center justify-center py-20 text-slate-400">
            <i data-lucide="refresh-cw" class="h-10 w-10 animate-spin text-cyan-500 mb-4"></i>
            <p class="text-sm font-medium">Fetching vehicle registry data from fleet engine...</p>
        </div>

        <div id="detailsContent" class="hidden">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('admin.vehicles.index') }}" class="mb-3 inline-flex items-center gap-2 text-sm font-semibold text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                        <i data-lucide="arrow-left" class="h-4 w-4"></i>
                        Back to vehicles
                    </a>
                    <h1 id="vehicleTitleName" class="text-3xl font-bold text-slate-900 dark:text-white">Loading...</h1>
                    <p id="vehicleSubtitleDesc" class="mt-1 text-slate-600 dark:text-slate-400"></p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <a id="editVehicleBtn" href="#" class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                        Edit
                    </a>
                    <button type="button" class="inline-flex items-center justify-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2.5 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                        <i data-lucide="calendar-plus" class="h-4 w-4"></i>
                        New Booking
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <section class="xl:col-span-2 space-y-6">
                    <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="flex aspect-[16/7] items-center justify-center bg-gradient-to-br from-cyan-500 via-blue-600 to-slate-900 overflow-hidden relative">
                            <img id="vehicleImage" src="" alt="Vehicle image preview" class="hidden h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            <div id="imageFallback" class="flex items-center justify-center">
                                <i data-lucide="car" class="h-24 w-24 text-white/70"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h2 id="mainSectionHeader" class="text-xl font-bold text-slate-900 dark:text-white"></h2>
                                    <p id="mainSectionSubtext" class="mt-1 text-sm text-slate-500 dark:text-slate-400"></p>
                                </div>
                                <span id="statusBadge" class="inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    <span id="statusText"></span>
                                </span>
                            </div>

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Price / Day</p>
                                    <p id="cardPrice" class="mt-2 text-2xl font-bold text-slate-900 dark:text-white">$0</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">License Plate</p>
                                    <p id="cardPlate" class="mt-2 text-lg font-bold text-slate-900 dark:text-white">-</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Capacity</p>
                                    <p id="cardCapacity" class="mt-2 text-lg font-bold text-slate-900 dark:text-white">-</p>
                                </div>
                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Color</p>
                                    <p id="cardColor" class="mt-2 text-lg font-bold text-slate-900 dark:text-white">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Vehicle Overview</h3>
                        <p id="vehicleDescription" class="text-sm leading-relaxed text-slate-600 dark:text-slate-400 whitespace-pre-line">
                            No functional system descriptions are bound to this asset registry record.
                        </p>
                    </div>
                </section>

                <aside class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800 h-fit">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Specifications</h2>
                    <div id="specsContainer" class="mt-5 space-y-4">
                        </div>
                </aside>
            </div>

            <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Recent Activity</h2>
                    <div class="mt-5 space-y-4">
                        <div class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-cyan-500"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">Vehicle inspection completed</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Today at 09:30 AM</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <span class="mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">System state sync check</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">Yesterday at 04:12 PM</p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Booking Summary</h2>
                    <div class="mt-5 grid grid-cols-3 gap-3">
                        <div class="rounded-xl bg-cyan-50 p-4 text-center dark:bg-cyan-950/40">
                            <p class="text-2xl font-bold text-cyan-700 dark:text-cyan-300">18</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Bookings</p>
                        </div>
                        <div class="rounded-xl bg-emerald-50 p-4 text-center dark:bg-emerald-950/40">
                            <p class="text-2xl font-bold text-emerald-700 dark:text-emerald-300">96%</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Uptime</p>
                        </div>
                        <div class="rounded-xl bg-blue-50 p-4 text-center dark:bg-blue-950/40">
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300">4.8</p>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Rating</p>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const vehicleId = $('#vehicleDetailsContainer').attr('data-id');

                function refreshIcons() {
                    if (window.lucide && typeof window.lucide.createIcons === 'function') {
                        window.lucide.createIcons();
                    }
                }

                function fetchVehicleData() {
                    $.ajax({
                        url: `/api/admin/vehicles/${vehicleId}`,
                        method: 'GET',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        },
                        dataType: 'json',
                        success: function(response) {
                            const vehicle = response.vehicle || response.data || response;
                            
                            const brandName = vehicle.brand?.name || 'Unknown';
                            const modelName = vehicle.model || 'Unknown Model';
                            const fullName = `${brandName} ${modelName}`;
                            
                            $('#vehicleTitleName').text(fullName);
                            $('#vehicleSubtitleDesc').text(`${fullName} registration data profile details.`);
                            $('#mainSectionHeader').text(fullName);
                            $('#mainSectionSubtext').text(`${vehicle.category?.name || 'Standard'} Fleet Classification`);
                            
                            // Handling dynamic vehicle image setup smoothly
                            const $img = $('#vehicleImage');
                            const $fallback = $('#imageFallback');
                            
                            if (vehicle.image && vehicle.image.trim() !== '') {
                                const imagePath = vehicle.image.startsWith('http') ? vehicle.image : `/storage/${vehicle.image}`;
                                $img.attr('src', imagePath).removeClass('hidden');
                                $fallback.addClass('hidden');
                            } else {
                                $img.addClass('hidden');
                                $fallback.removeClass('hidden');
                            }
                            
                            // Base text updates
                            const formattedPrice = new Intl.NumberFormat('en-US', { style: 'currency', currency: 'USD' }).format(vehicle.price_per_day || 0);
                            $('#cardPrice').text(formattedPrice);
                            $('#cardPlate').text(vehicle.license_plate || '-');
                            $('#cardCapacity').text(vehicle.capacity ? `${vehicle.capacity} Seats` : '-');
                            $('#cardColor').text(vehicle.color || '-');

                            if (vehicle.description && vehicle.description.trim() !== '') {
                                $('#vehicleDescription').text(vehicle.description);
                            }

                            $('#editVehicleBtn').attr('href', `/admin/vehicles/${vehicle.id}/edit`);

                            // Status processing setup
                            const rawStatus = (vehicle.status || 'available').toLowerCase();
                            let badgeStyle = 'bg-amber-100 text-amber-700 dark:bg-amber-950 dark:text-amber-300';
                            
                            if (rawStatus === 'available') {
                                badgeStyle = 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950 dark:text-emerald-300';
                            } else if (rawStatus === 'rented') {
                                badgeStyle = 'bg-cyan-100 text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300';
                            }
                            
                            $('#statusBadge').attr('class', `inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold ${badgeStyle}`);
                            $('#statusText').text(rawStatus.charAt(0).toUpperCase() + rawStatus.slice(1));

                            // Form dynamic specifications sidebar cleanly filtering database IDs
                            const specList = [
                                { label: 'Category', value: vehicle.category?.name || 'N/A' },
                                { label: 'Brand', value: brandName },
                                { label: 'Model', value: modelName },
                                { label: 'Year Manufactured', value: vehicle.year || 'N/A' },
                                { label: 'License Plate', value: vehicle.license_plate || 'N/A' },
                                { label: 'Body Color', value: vehicle.color || 'N/A' },
                                { label: 'Seating Capacity', value: vehicle.capacity || 'N/A' }
                            ];

                            let specRows = '';
                            specList.forEach(spec => {
                                specRows += `
                                    <div class="flex items-start justify-between gap-4 border-b border-slate-100 pb-3 last:border-0 dark:border-slate-700">
                                        <span class="text-sm text-slate-500 dark:text-slate-400">${spec.label}</span>
                                        <span class="text-right text-sm font-semibold text-slate-900 dark:text-white">${spec.value}</span>
                                    </div>`;
                            });
                            $('#specsContainer').html(specRows);

                            $('#loadingState').addClass('hidden');
                            $('#detailsContent').removeClass('hidden');
                            refreshIcons();
                        },
                        error: function() {
                            $('#loadingState').html(`
                                <div class="text-center p-6 text-red-500">
                                    <i data-lucide="alert-circle" class="h-10 w-10 mx-auto mb-2"></i>
                                    <p class="font-bold">Failed to load vehicle registry validation endpoints.</p>
                                </div>
                            `);
                            refreshIcons();
                        }
                    });
                }

                fetchVehicleData();
            });
        </script>
    @endpush
</x-admin.layout>