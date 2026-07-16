<x-admin.layout>
    <div id="formLayoutWrapper" data-page="admin-driver-form" data-edit="{{ $isEdit ? 'true' : 'false' }}" data-id="{{ $driverId ?? '' }}" data-drivers-api="{{ url('/api/admin/drivers') }}" data-vehicles-api="{{ url('/api/admin/vehicles') }}" data-index-url="{{ route('admin.drivers.index') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">
        <!-- Page Header -->
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 id="formPageHeader" class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">
                        {{ $isEdit ? 'Edit Driver Profile' : 'Add New Driver' }}
                    </h1>
                    <p id="formPageSubheader" class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="{{ $isEdit ? 'edit' : 'plus-circle' }}" class="h-3 w-3"></i>
                        <span>{{ $isEdit ? 'Update this driver profile' : 'Add a driver to your fleet' }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.drivers.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <!-- Form Column -->
            <form id="driverForm" class="order-2 lg:order-1 space-y-5" enctype="multipart/form-data">
                @csrf

                <!-- Personal Details Section -->
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Personal details</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <!-- Name -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                            <input type="text" name="name" id="driverName" placeholder="e.g., John Doe" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <!-- Email -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                            <input type="email" name="email" id="driverEmail" placeholder="e.g., john@example.com" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <!-- Phone -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone Number</label>
                            <input type="text" name="phone" id="driverPhone" placeholder="e.g., +1 555-123-4567" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <!-- License Number -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">License Number</label>
                            <input type="text" name="license_number" id="driverLicenseNumber" placeholder="e.g., DL-1234-5678" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <!-- License Expiry -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">License Expiry Date</label>
                            <input type="text" name="license_expiry_date" id="driverLicenseExpiry" placeholder="Select Date" class="date-picker w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <!-- License Type -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Driving License Type</label>
                            <select name="driving_license_type_id" id="drivingLicenseTypeId" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">Select license type</option>
                            </select>
                        </div>
                        <!-- Status -->
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                            <select name="status" id="driverStatus" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="available">Available</option>
                                <option value="on_trip">On Trip</option>
                                <option value="off_duty">Off Duty</option>
                            </select>
                        </div>
                        <!-- Vehicle Assignment -->
                        <div class="sm:col-span-2">
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Assign Vehicles</label>
                            <div id="vehicleAssignment" class="grid grid-cols-1 gap-4 sm:grid-cols-[1fr_auto_1fr]">
                                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800/50">
                                    <div class="border-b border-slate-200 dark:border-slate-600 px-3 py-2">
                                        <input type="text" id="unassignedSearch" placeholder="Search by brand, model, category..." class="w-full rounded-md border border-slate-300 bg-white px-3 py-1.5 text-xs focus:border-cyan-500 focus:outline-none dark:border-slate-600 dark:bg-slate-700 dark:text-slate-200">
                                    </div>
                                    <ul id="unassignedList" class="max-h-48 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700">
                                        <li class="px-3 py-4 text-center text-xs text-slate-400">Loading vehicles...</li>
                                    </ul>
                                </div>
                                <div class="flex flex-row sm:flex-col items-center justify-center gap-2">
                                    <button type="button" id="assignBtn" class="rounded-lg bg-cyan-400 p-2 text-black hover:bg-cyan-500 disabled:opacity-40" disabled><i data-lucide="chevron-right" class="h-4 w-4"></i></button>
                                    <button type="button" id="unassignBtn" class="rounded-lg bg-slate-300 p-2 text-slate-700 hover:bg-slate-400 disabled:opacity-40 dark:bg-slate-600 dark:text-slate-300" disabled><i data-lucide="chevron-left" class="h-4 w-4"></i></button>
                                </div>
                                <div class="rounded-lg border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-800/50">
                                    <div class="border-b border-slate-200 dark:border-slate-600 px-3 py-2">
                                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">Assigned (<span id="assignedCount">0</span>)</span>
                                    </div>
                                    <ul id="assignedList" class="max-h-48 overflow-y-auto divide-y divide-slate-100 dark:divide-slate-700"></ul>
                                </div>
                            </div>
                            <input type="hidden" name="vehicle_ids" id="vehicleIdsInput" value="">
                            <input type="hidden" name="primary_vehicle_id" id="primaryVehicleIdInput" value="">
                            <p class="mt-1.5 text-xs text-slate-400">Select a vehicle in the right column, then click "Set as Primary" to mark it as the default.</p>
                        </div>
                    </div>
                </section>

                <!-- Photo & Address Section -->
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Photo & Address</h2>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Driver photo</label>
                        <div id="imageUploadArea" class="relative overflow-hidden rounded-lg border border-dashed border-slate-300 bg-slate-50 transition hover:border-cyan-500 hover:bg-cyan-50/50 dark:border-slate-600 dark:bg-slate-700/50 dark:hover:border-cyan-500 dark:hover:bg-cyan-950/20">
                            <input type="file" name="image" id="imageInput" class="sr-only" accept="image/*">

                            <div id="uploadPlaceholder" class="flex cursor-pointer items-center justify-center gap-3 px-3 py-2.5">
                                <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cyan-100 dark:bg-cyan-900/50">
                                    <i data-lucide="image-plus" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                                </div>
                                <div class="text-left">
                                    <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Choose photo</p>
                                </div>
                            </div>

                            <div id="fileInfoContainer" class="hidden">
                                <div class="flex items-center justify-between gap-2 px-3 py-2">
                                    <div class="flex min-w-0 items-center gap-2">
                                        <div class="flex h-7 w-7 shrink-0 items-center justify-center rounded-lg bg-cyan-100 dark:bg-cyan-900/50">
                                            <i data-lucide="file-image" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p id="fileNameDisplay" class="truncate text-xs font-medium text-slate-700 dark:text-slate-300"></p>
                                            <p id="fileSizeDisplay" class="text-[10px] text-slate-500 dark:text-slate-400"></p>
                                        </div>
                                    </div>
                                    <button type="button" id="removeImageBtn" class="shrink-0 rounded-lg p-1 text-slate-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/50 dark:hover:text-red-400" title="Remove image">
                                        <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <p id="imageError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></p>
                    </div>
                    <div class="mt-4">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Address</label>
                        <textarea name="address" id="driverAddress" rows="3" placeholder="Enter driver address..." class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white"></textarea>
                    </div>
                </section>

                <!-- Form Actions -->
                <div class="flex gap-3">
                    <button type="submit" id="submitFormBtn" class="flex-1 rounded-lg bg-cyan-400 px-5 py-2.5 text-center text-sm font-bold text-black transition hover:bg-cyan-500">
                        {{ $isEdit ? 'Update Driver' : 'Create Driver' }}
                    </button>
                    <button type="button" id="cancelFormBtn" class="flex-1 rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                        Cancel
                    </button>
                </div>
            </form>

            <!-- Preview Sidebar -->
            <aside class="order-1 lg:order-2 lg:sticky lg:top-20 lg:self-start">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Live Preview</h3>
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-inner dark:border-slate-700 dark:bg-slate-900">
                        <div class="relative flex aspect-video items-center justify-center overflow-hidden bg-gradient-to-br from-cyan-400 to-blue-600">
                            <img id="previewImg" src="" class="absolute inset-0 hidden h-full w-full object-cover" alt="Driver preview">
                            <i id="previewIcon" data-lucide="id-card" class="h-16 w-16 text-white opacity-30"></i>
                            <span id="previewBadge" class="absolute right-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-semibold text-slate-800 shadow-sm backdrop-blur-sm dark:bg-slate-800/90 dark:text-slate-200">
                                {{ $isEdit ? 'Updating' : 'New' }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h4 id="previewTitle" class="truncate text-lg font-black text-slate-900 dark:text-white">Driver Name</h4>
                            <p id="previewPhone" class="mt-1 text-xs text-slate-500 dark:text-slate-400">Not Provided</p>
                            <p id="previewAddress" class="mt-2 min-h-[2rem] text-xs leading-relaxed text-slate-600 line-clamp-3 dark:text-slate-400">No address provided yet.</p>
                            <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-3 dark:border-slate-700">
                                <div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">License</p>
                                    <p id="previewLicense" class="text-base font-black text-slate-950 dark:text-white">Not Set</p>
                                </div>
                                <span id="previewStatusBadge" class="rounded-full bg-green-100 px-2.5 py-1 text-[10px] font-semibold text-green-700 dark:bg-green-900/30 dark:text-green-400">Available</span>
                            </div>
                        </div>
                    </article>
                </div>
            </aside>
        </div>
    </div>
</x-admin.layout>