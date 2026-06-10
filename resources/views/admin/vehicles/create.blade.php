<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Add New Vehicle</h1>
                <p class="mt-1 text-slate-600 dark:text-slate-400">Create a new vehicle for your fleet</p>
            </div>
            <a href="/admin/vehicles" class="flex items-center gap-2 rounded-lg border border-slate-300 px-4 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                <i data-lucide="arrow-left" class="h-5 w-5"></i>
                Back
            </a>
        </div>

        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
            <!-- Form Section -->
            <div class="lg:col-span-2">
                <form class="space-y-6">
                    <!-- Basic Information -->
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h2 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">Basic Information</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Brand</label>
                                    <select class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                        <option>Select Brand</option>
                                        <option>BMW</option>
                                        <option>Lexus</option>
                                        <option>Mercedes</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Model</label>
                                    <input type="text" placeholder="e.g., 7 Series" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Year</label>
                                    <input type="number" placeholder="2024" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">License Plate</label>
                                    <input type="text" placeholder="BM-2048" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Category</label>
                                <select class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                    <option>Select Category</option>
                                    <option>Economy</option>
                                    <option>Luxury</option>
                                    <option>SUV</option>
                                    <option>Sports</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">VIN (Vehicle Identification Number)</label>
                                <input type="text" placeholder="WBADT43452G296706" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Availability -->
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h2 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">Pricing & Availability</h2>
                        <div class="space-y-4">
                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Daily Rate ($)</label>
                                    <input type="number" placeholder="150.00" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Weekly Rate ($)</label>
                                    <input type="number" placeholder="900.00" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Monthly Rate ($)</label>
                                    <input type="number" placeholder="3500.00" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Security Deposit ($)</label>
                                    <input type="number" placeholder="500.00" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <input type="checkbox" id="available" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                <label for="available" class="text-sm font-medium text-slate-700 dark:text-slate-300">Available for booking</label>
                            </div>
                        </div>
                    </div>

                    <!-- Features & Specifications -->
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <h2 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">Features & Specifications</h2>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Transmission</label>
                                <select class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                    <option>Automatic</option>
                                    <option>Manual</option>
                                </select>
                            </div>

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Fuel Type</label>
                                    <select class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                        <option>Petrol</option>
                                        <option>Diesel</option>
                                        <option>Hybrid</option>
                                        <option>Electric</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Number of Seats</label>
                                    <input type="number" placeholder="5" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Amenities</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Air Conditioning</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">GPS Navigation</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Sunroof</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Backup Camera</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">WiFi Hotspot</span>
                                    </label>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                        <span class="text-sm text-slate-700 dark:text-slate-300">Bluetooth</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-3 text-center text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                            Add Vehicle
                        </button>
                        <button type="button" class="flex-1 rounded-lg border border-slate-300 px-6 py-3 text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>

            <!-- Preview Section -->
            <div class="lg:col-span-1">
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm sticky top-24 dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="mb-4 text-lg font-bold text-slate-900 dark:text-white">Preview</h3>
                    <div class="rounded-lg bg-gradient-to-br from-cyan-400 to-blue-600 aspect-video flex items-center justify-center mb-4">
                        <i data-lucide="car" class="h-16 w-16 text-white opacity-30"></i>
                    </div>
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Model</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">BMW 7 Series</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Category</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">Luxury Sedan</p>
                        </div>
                        <div>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Daily Rate</p>
                            <p class="text-sm font-semibold text-slate-900 dark:text-white">$150.00 / day</p>
                        </div>
                        <div class="pt-3 border-t border-slate-200 dark:border-slate-700">
                            <div class="flex items-center gap-2">
                                <i data-lucide="check" class="h-4 w-4 text-green-600 dark:text-green-400"></i>
                                <span class="text-sm text-slate-700 dark:text-slate-300">Ready to publish</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin.layout>
