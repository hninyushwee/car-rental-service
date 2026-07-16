@php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
@endphp

<x-admin.layout>
    <div id="vehicleDetailsContainer" data-page="admin-vehicle-show" data-id="{{ $vehicleId }}"
        data-api-base="{{ url('/api/admin/vehicles') }}" data-login-url="{{ route('login') }}" data-admin-url="{{ $adminUrl }}" class="p-4 sm:p-6 md:p-8">

        <div id="loadingState" class="flex items-center justify-center py-20">
            <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400">
                <svg class="h-6 w-6 animate-spin" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                Loading vehicle details...
            </div>
        </div>

        <div id="detailsContent" class="hidden">
            <div class="mb-8">
                <a href="{{ $adminUrl }}/vehicles" class="mb-4 inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 id="vehicleTitleName" class="text-2xl font-bold text-slate-900 dark:text-white">Loading...</h1>
                        <p id="vehicleSubtitleDesc" class="mt-1 text-slate-600 dark:text-slate-400"></p>
                    </div>
                    @role('super-admin')
                    <a id="editVehicleBtn" href="#"
                        class="shrink-0 inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                        Edit
                    </a>
                    @endrole
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <section class="xl:col-span-2 space-y-6">
                    <div
                        class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div
                            class="flex aspect-[16/7] items-center justify-center bg-gradient-to-br from-cyan-500 via-blue-600 to-slate-900 overflow-hidden relative">
                            <img id="vehicleImage" src="" alt="Vehicle image preview"
                                class="hidden h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            <div id="imageFallback" class="flex items-center justify-center">
                                <i data-lucide="car" class="h-24 w-24 text-white/70"></i>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                <div>
                                    <h2 id="mainSectionHeader" class="text-lg font-bold text-slate-900 dark:text-white">
                                    </h2>
                                    <p id="mainSectionSubtext" class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                                    </p>
                                </div>
                                <span id="statusBadge"
                                    class="inline-flex w-fit items-center gap-2 rounded-full px-3 py-1 text-xs font-bold">
                                    <span class="h-2 w-2 rounded-full bg-current"></span>
                                    <span id="statusText"></span>
                                </span>
                            </div>

                            <div class="mt-6 flex flex-col gap-4 sm:flex-row">
                                <div class="flex-1 rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Price / Day</p>
                                    <p id="cardPrice" class="mt-2 font-bold text-slate-900 dark:text-white">MMK 0</p>
                                </div>

                                <div class="flex-[2] rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Stock (Avail / Total)</p>
                                    <p id="cardStock"
                                        class="mt-2 font-bold text-slate-900 dark:text-white">-
                                    </p>
                                </div>

                                <div class="flex-1 rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Capacity</p>
                                    <p id="cardCapacity" class="mt-2 font-bold text-slate-900 dark:text-white">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Vehicle Overview</h3>
                        <p id="vehicleDescription"
                            class="text-sm leading-relaxed text-slate-600 dark:text-slate-400 whitespace-pre-line">
                            No functional system descriptions are bound to this asset registry record.
                        </p>

                        <div id="driversSection" class="mt-6 hidden">
                            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Assigned Drivers</h4>
                            <div id="driversList" class="space-y-3"></div>
                        </div>
                    </div>
                </section>

                <!-- Redesigned Specifications Section with Sticky Positioning -->
                <aside class="xl:col-span-1">
                    <div
                        class="sticky top-6 rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800 transition-all duration-300 hover:shadow-md">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Specifications</h2>
                            <span
                                class="rounded-full bg-cyan-100 px-2.5 py-0.5 text-xs font-semibold text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400">
                                <span id="specCount">0</span> specs
                            </span>
                        </div>

                        <div id="specsContainer"
                            class="space-y-3 max-h-[calc(100vh-12rem)] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-600">
                            <!-- Specifications will be populated here -->
                        </div>

                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-admin.layout>
