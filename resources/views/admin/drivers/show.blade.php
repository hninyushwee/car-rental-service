@php
    $adminUrl = auth()->user()->hasRole('super-admin') ? '/admin' : '/staff';
@endphp

<x-admin.layout>
    <div id="driverDetailsContainer" data-page="admin-driver-show" data-id="{{ $driverId }}"
        data-api-base="{{ url('/api/admin/drivers') }}" data-login-url="{{ route('login') }}" data-admin-url="{{ $adminUrl }}" class="p-4 sm:p-6 md:p-8">

        <div id="loadingState" class="py-20">
            <div class="mb-8 flex items-center justify-between">
                <div>
                    <div class="skeleton h-3 w-16 mb-3"></div>
                    <div class="skeleton h-7 w-56 mb-2"></div>
                    <div class="skeleton h-4 w-36"></div>
                </div>
                <div class="skeleton h-10 w-24 rounded-lg"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 space-y-6">
                    <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white/90 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                        <div class="skeleton aspect-[16/7] w-full"></div>
                        <div class="p-6 space-y-4">
                            <div class="skeleton h-5 w-48"></div>
                            <div class="flex gap-4">
                                <div class="flex-1 skeleton h-16 rounded-xl"></div>
                                <div class="flex-1 skeleton h-16 rounded-xl"></div>
                                <div class="flex-1 skeleton h-16 rounded-xl"></div>
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                        <div class="skeleton h-5 w-36 mb-4"></div>
                        <div class="space-y-2">
                            <div class="skeleton h-14 w-full"></div>
                            <div class="skeleton h-14 w-full"></div>
                        </div>
                    </div>
                </div>
                <aside class="xl:col-span-1">
                    <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                        <div class="skeleton h-5 w-32 mb-4"></div>
                        <div class="space-y-2">
                            <div class="skeleton h-4 w-full"></div>
                            <div class="skeleton h-4 w-full"></div>
                            <div class="skeleton h-4 w-3/4"></div>
                            <div class="skeleton h-4 w-1/2"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div id="detailsContent" class="hidden">
            <div class="mb-8">
                <a href="{{ $adminUrl }}/drivers" class="mb-4 inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 id="driverTitleName" class="text-2xl font-bold text-slate-900 dark:text-white">Loading...</h1>
                        <p id="driverSubtitleDesc" class="mt-1 text-slate-600 dark:text-slate-400"></p>
                    </div>
                    @role('super-admin')
                    <a id="editDriverBtn" href="#"
                        class="shrink-0 inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200 dark:hover:bg-slate-700">
                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                        Edit
                    </a>
                    @endrole
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <section class="xl:col-span-2 space-y-6">
                    <div class="overflow-hidden rounded-xl border border-slate-200/60 bg-white/90 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                        <div class="flex aspect-[16/7] items-center justify-center bg-gradient-to-br from-cyan-500 via-blue-600 to-slate-900 overflow-hidden relative">
                            <img id="driverImage" src="" alt="Driver image preview"
                                class="hidden h-full w-full object-cover transition-transform duration-500 hover:scale-105">
                            <div id="imageFallback" class="flex items-center justify-center">
                                <i data-lucide="id-card" class="h-24 w-24 text-white/70"></i>
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

                            <div class="mt-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">Phone</p>
                                    <p id="cardPhone" class="mt-2 font-bold text-slate-900 dark:text-white">-</p>
                                </div>

                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">License Type</p>
                                    <p id="cardLicenseType" class="mt-2 font-bold text-slate-900 dark:text-white">-</p>
                                </div>

                                <div class="rounded-xl bg-slate-50 p-4 dark:bg-slate-900">
                                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">License</p>
                                    <p id="cardLicense" class="mt-2 font-bold text-slate-900 dark:text-white">-</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90">
                        <div id="vehiclesSection" class="hidden">
                            <h4 class="mb-3 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Assigned Vehicles</h4>
                            <div id="vehiclesList" class="space-y-3"></div>
                        </div>
                    </div>
                </section>

                <aside class="xl:col-span-1">
                    <div class="sticky top-6 rounded-xl border border-slate-200/60 bg-white/90 p-6 shadow-sm dark:border-slate-700/60 dark:bg-slate-800/90 transition-all duration-300 hover:shadow-md">
                        <div class="flex items-center justify-between mb-5">
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Specifications</h2>
                            <span class="rounded-full bg-cyan-100 px-2.5 py-0.5 text-xs font-semibold text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400">
                                <span id="specCount">0</span> specs
                            </span>
                        </div>

                        <div id="specsContainer"
                            class="space-y-3 max-h-[calc(100vh-12rem)] overflow-y-auto pr-1 scrollbar-thin scrollbar-thumb-slate-300 dark:scrollbar-thumb-slate-600">
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-admin.layout>
