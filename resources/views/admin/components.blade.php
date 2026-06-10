<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-slate-900 dark:text-white">Component Library</h1>
            <p class="mt-1 text-slate-600 dark:text-slate-400">Reusable UI components for the SkyLine Admin Dashboard</p>
        </div>

        <!-- Buttons -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Buttons</h2>
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="space-y-4">
                    <div class="flex flex-wrap gap-3">
                        <button class="rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                            Primary Button
                        </button>
                        <button class="rounded-lg border border-slate-300 px-6 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                            Secondary Button
                        </button>
                        <button class="rounded-lg border border-red-300 px-6 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50 dark:border-red-600 dark:hover:bg-red-950">
                            Danger Button
                        </button>
                        <button disabled class="rounded-lg bg-slate-200 px-6 py-2.5 text-sm font-medium text-slate-400 cursor-not-allowed dark:bg-slate-700 dark:text-slate-500">
                            Disabled Button
                        </button>
                    </div>

                    <div class="flex flex-wrap gap-3 pt-4">
                        <button class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-4 py-2 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                            <i data-lucide="plus" class="h-5 w-5"></i>
                            With Icon
                        </button>
                        <button class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-3 py-3 text-white shadow-lg hover:shadow-xl">
                            <i data-lucide="check" class="h-5 w-5"></i>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <!-- Status Badges -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Status Badges</h2>
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="flex flex-wrap gap-4">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700 dark:bg-green-950 dark:text-green-300">
                        <span class="h-2 w-2 rounded-full bg-green-600"></span>
                        Active
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-cyan-100 px-3 py-1 text-xs font-medium text-cyan-700 dark:bg-cyan-950 dark:text-cyan-300">
                        <span class="h-2 w-2 rounded-full bg-cyan-600"></span>
                        Confirmed
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-yellow-100 px-3 py-1 text-xs font-medium text-yellow-700 dark:bg-yellow-950 dark:text-yellow-300">
                        <span class="h-2 w-2 rounded-full bg-yellow-600"></span>
                        Pending
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-700 dark:bg-slate-700 dark:text-slate-300">
                        <span class="h-2 w-2 rounded-full bg-slate-600"></span>
                        Completed
                    </span>
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-medium text-red-700 dark:bg-red-950 dark:text-red-300">
                        <span class="h-2 w-2 rounded-full bg-red-600"></span>
                        Cancelled
                    </span>
                </div>
            </div>
        </section>

        <!-- Form Elements -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Form Elements</h2>
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Text Input</label>
                        <input type="text" placeholder="Placeholder text" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Select Dropdown</label>
                        <select class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option>Option 1</option>
                            <option>Option 2</option>
                            <option>Option 3</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Textarea</label>
                        <textarea placeholder="Multi-line text" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white" rows="4"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-3">Checkboxes</label>
                        <div class="space-y-2">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" checked class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Checkbox 1</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" class="h-4 w-4 rounded border-slate-300 text-cyan-600">
                                <span class="text-sm text-slate-700 dark:text-slate-300">Checkbox 2</span>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Alert Messages -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Alert Messages</h2>
            <div class="space-y-4">
                <div class="rounded-lg border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                    <div class="flex gap-3">
                        <i data-lucide="check-circle" class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"></i>
                        <div>
                            <h3 class="font-semibold text-green-800 dark:text-green-200">Success!</h3>
                            <p class="mt-1 text-sm text-green-700 dark:text-green-300">Operation completed successfully.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-blue-200 bg-blue-50 p-4 dark:border-blue-900 dark:bg-blue-950">
                    <div class="flex gap-3">
                        <i data-lucide="info" class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400"></i>
                        <div>
                            <h3 class="font-semibold text-blue-800 dark:text-blue-200">Information</h3>
                            <p class="mt-1 text-sm text-blue-700 dark:text-blue-300">This is an informational message.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-yellow-200 bg-yellow-50 p-4 dark:border-yellow-900 dark:bg-yellow-950">
                    <div class="flex gap-3">
                        <i data-lucide="alert-circle" class="h-5 w-5 flex-shrink-0 text-yellow-600 dark:text-yellow-400"></i>
                        <div>
                            <h3 class="font-semibold text-yellow-800 dark:text-yellow-200">Warning</h3>
                            <p class="mt-1 text-sm text-yellow-700 dark:text-yellow-300">Please review this warning message.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-lg border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950">
                    <div class="flex gap-3">
                        <i data-lucide="x-circle" class="h-5 w-5 flex-shrink-0 text-red-600 dark:text-red-400"></i>
                        <div>
                            <h3 class="font-semibold text-red-800 dark:text-red-200">Error</h3>
                            <p class="mt-1 text-sm text-red-700 dark:text-red-300">An error occurred while processing your request.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cards -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Card Variants</h2>
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <!-- Basic Card -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="font-bold text-slate-900 dark:text-white">Basic Card</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Simple card with border and shadow.</p>
                </div>

                <!-- Card with Icon -->
                <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm transition hover:shadow-md dark:border-slate-700 dark:bg-slate-800">
                    <div class="mb-4 inline-flex rounded-lg bg-cyan-100 p-3 dark:bg-cyan-950">
                        <i data-lucide="rocket" class="h-6 w-6 text-cyan-600 dark:text-cyan-400"></i>
                    </div>
                    <h3 class="font-bold text-slate-900 dark:text-white">With Icon</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Card with icon and hover effect.</p>
                </div>

                <!-- Gradient Card -->
                <div class="rounded-xl border border-cyan-200 bg-gradient-to-br from-cyan-50 to-blue-50 p-6 dark:border-cyan-900 dark:from-cyan-950 dark:to-blue-950">
                    <h3 class="font-bold text-slate-900 dark:text-white">Gradient Card</h3>
                    <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Card with gradient background.</p>
                </div>
            </div>
        </section>

        <!-- Progress Bars -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Progress Bars</h2>
            <div class="rounded-xl border border-slate-200 bg-white p-8 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="space-y-6">
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Vehicle Utilization</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">85%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700">
                            <div class="h-full w-4/5 rounded-full bg-gradient-to-r from-cyan-500 to-blue-600"></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Booking Rate</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">72%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700">
                            <div class="h-full w-3/4 rounded-full bg-gradient-to-r from-green-500 to-emerald-600"></div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Revenue Target</span>
                            <span class="text-sm font-semibold text-slate-900 dark:text-white">58%</span>
                        </div>
                        <div class="h-2 rounded-full bg-slate-200 dark:bg-slate-700">
                            <div class="h-full w-3/5 rounded-full bg-gradient-to-r from-amber-500 to-orange-600"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Empty States -->
        <section class="mb-12">
            <h2 class="mb-6 text-2xl font-bold text-slate-900 dark:text-white">Empty State</h2>
            <div class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-12 text-center dark:border-slate-600 dark:bg-slate-900">
                <i data-lucide="inbox" class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-600"></i>
                <h3 class="mt-4 text-lg font-semibold text-slate-900 dark:text-white">No data available</h3>
                <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Create your first item to get started.</p>
                <button class="mt-6 inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-6 py-2.5 text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                    <i data-lucide="plus" class="h-5 w-5"></i>
                    Create Item
                </button>
            </div>
        </section>
    </div>
</x-admin.layout>
