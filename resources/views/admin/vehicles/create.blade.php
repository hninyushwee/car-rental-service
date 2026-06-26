<x-admin.layout>
    <div id="formLayoutWrapper" data-page="admin-vehicle-form" data-edit="{{ $isEdit ? 'true' : 'false' }}" data-id="{{ $vehicleId ?? '' }}" data-vehicles-api="{{ url('/api/admin/vehicles') }}" data-brands-api="{{ url('/api/admin/brands') }}" data-categories-api="{{ url('/api/admin/categories') }}" data-index-url="{{ route('admin.vehicles.index') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 backdrop-blur-sm dark:border-cyan-500/10 sm:px-5 sm:py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 id="formPageHeader" class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-lg font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-xl">
                        {{ $isEdit ? 'Edit Vehicle Profile' : 'Add New Vehicle' }}
                    </h1>
                    <p id="formPageSubheader" class="mt-0.5 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <i data-lucide="{{ $isEdit ? 'edit' : 'plus-circle' }}" class="h-4 w-4"></i>
                        <span>{{ $isEdit ? 'Update this vehicle profile' : 'Add a vehicle to your fleet' }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.vehicles.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <form id="vehicleForm" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Vehicle details</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Brand</label>
                            <select name="brand_id" id="vehicleBrand" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">Loading Brands...</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Model</label>
                            <input type="text" name="model" id="vehicleModel" placeholder="e.g., 7 Series" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Year</label>
                            <input type="text" name="year" id="vehicleYear" placeholder="Select Year" class="year-picker w-full cursor-pointer rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">License Plate</label>
                            <input type="text" name="license_plate" id="vehiclePlate" placeholder="YGN-2048" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Color</label>
                            <input type="text" name="color" id="vehicleColor" placeholder="e.g., Metallic Black" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Capacity (Seats)</label>
                            <input type="number" name="capacity" id="vehicleCapacity" placeholder="e.g., 5" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                            <select name="category_id" id="vehicleCategory" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">Loading Categories...</option>
                            </select>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Status</label>
                            <select name="status" id="vehicleStatus" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="available">Available</option>
                                <option value="rented">Rented</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Description</label>
                        <textarea name="description" id="vehicleDescription" rows="3" placeholder="Enter vehicle special features..." class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white"></textarea>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Price and photo</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Price Per Day ($)</label>
                            <input type="number" step="0.01" name="price_per_day" id="vehiclePrice" placeholder="150.00" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Vehicle photo</label>
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
                    </div>
                </section>

                <div class="flex gap-3">
                    <button type="submit" id="submitFormBtn" class="flex-1 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2.5 text-center text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                        {{ $isEdit ? 'Save Changes' : 'Add Vehicle' }}
                    </button>
                    <button type="button" id="cancelFormBtn" class="flex-1 rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                        Cancel
                    </button>
                </div>
            </form>

            <aside class="lg:sticky lg:top-20 lg:self-start">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Live Preview</h3>
                    <article class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-inner dark:border-slate-700 dark:bg-slate-900">
                        <div class="relative flex aspect-video items-center justify-center overflow-hidden bg-gradient-to-br from-cyan-400 to-blue-600">
                            <img id="previewImg" src="" class="absolute inset-0 hidden h-full w-full object-cover" alt="Vehicle preview">
                            <i id="previewIcon" data-lucide="car" class="h-16 w-16 text-white opacity-30"></i>
                            <span id="previewBadge" class="absolute right-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-[10px] font-semibold text-slate-800 shadow-sm backdrop-blur-sm dark:bg-slate-800/90 dark:text-slate-200">
                                {{ $isEdit ? 'Updating' : 'New' }}
                            </span>
                        </div>
                        <div class="p-4">
                            <h4 id="previewTitle" class="truncate text-lg font-black text-slate-900 dark:text-white">Vehicle Model</h4>
                            <p id="previewCategory" class="mt-1 text-xs text-slate-500 dark:text-slate-400">Not Selected</p>
                            <p id="previewDescription" class="mt-2 min-h-[2rem] text-xs leading-relaxed text-slate-600 line-clamp-3 dark:text-slate-400">No description provided yet.</p>
                            <div class="mt-4 flex items-center justify-between border-t border-slate-200 pt-3 dark:border-slate-700">
                                <div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Daily Rate</p>
                                    <p id="previewPrice" class="text-base font-black text-slate-950 dark:text-white">$0.00</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Deposit (10%)</p>
                                    <p id="previewDeposit" class="text-xs font-bold text-cyan-600 dark:text-cyan-400">$0.00</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </aside>
        </div>
    </div>
</x-admin.layout>
