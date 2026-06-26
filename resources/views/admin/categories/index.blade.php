<x-admin.layout>
    <div data-page="admin-categories" data-api-base="{{ url('/api/admin/categories') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 backdrop-blur-sm dark:border-cyan-500/10 sm:px-5 sm:py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-lg font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-xl">
                        Vehicle Categories
                    </h1>
                    <p class="mt-0.5 flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                        <i data-lucide="layers-3" class="h-4 w-4"></i>
                        Manage your fleet labels seamlessly on a single dashboard workspace.
                    </p>
                </div>
            </div>
        </div>

        <div id="alertContainer" class="mb-5 space-y-3">
            <div id="successBox" class="hidden rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="check-circle" class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-green-800 dark:text-green-200">Success!</h3>
                        <p id="successText" class="mt-1 text-sm text-green-700 dark:text-green-300"></p>
                    </div>
                    <button type="button" class="close-alert text-green-500 hover:text-green-700 dark:hover:text-green-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>

            <div id="errorBox" class="hidden rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="x-circle" class="h-5 w-5 flex-shrink-0 text-red-600 dark:text-red-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-800 dark:text-red-200">Action Blocked</h3>
                        <p id="errorText" class="mt-1 text-sm text-red-700 dark:text-red-300"></p>
                    </div>
                    <button type="button" class="close-alert text-red-500 hover:text-red-700 dark:hover:text-green-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Active Categories</h2>

                    <div class="relative w-full sm:w-64">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 dark:text-slate-500">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </span>
                        <input type="text" id="tableSearchInput" placeholder="Search categories..." class="h-9 w-full rounded-xl border border-slate-300 bg-white pl-9 pr-4 text-xs font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full border-collapse text-left">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:border-slate-700">
                                <th class="w-16 px-4 py-3">No</th>
                                <th class="px-4 py-3">Name</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody" class="divide-y divide-slate-100 text-sm text-slate-700 dark:divide-slate-700/50 dark:text-slate-300">
                            <tr>
                                <td colspan="3" class="py-6 text-center text-slate-400">Loading categories...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="lg:sticky lg:top-20 lg:self-start">
                <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-300">
                            <i id="formIcon" data-lucide="folder-plus" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <h3 id="formTitle" class="text-base font-bold text-slate-900 dark:text-white">New Category</h3>
                            <p id="formSubtitle" class="text-xs text-slate-500">Add a unique classification label.</p>
                        </div>
                    </div>

                    <form id="categoryForm" class="space-y-4">
                        <input type="hidden" id="category_id" value="">
                        <div>
                            <label for="category_name" class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-400">Category Name</label>
                            <input type="text" id="category_name" placeholder="Example: SUV, Sedan, Van" required class="h-11 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="button" id="cancelBtn" class="hidden h-10 w-1/3 rounded-xl border border-slate-200 text-xs font-bold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                                Cancel
                            </button>
                            <button type="submit" id="saveBtn" class="h-10 w-full rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 text-xs font-bold text-white shadow-md transition hover:-translate-y-0.5">
                                Save Record
                            </button>
                        </div>
                    </form>
                </section>
            </aside>
        </div>
    </div>

    <!-- Simple Delete Confirmation Modal -->
    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        
        <div class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-2xl transition-all dark:bg-slate-800">
            <div class="flex flex-col items-center text-center">
                <div class="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-red-100 dark:bg-red-900/30">
                    <i data-lucide="trash-2" class="h-8 w-8 text-red-600 dark:text-red-400"></i>
                </div>
                
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Category?</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">This action cannot be undone.</p>
            </div>
            
            <div class="mt-6 flex gap-3">
                <button type="button" id="closeDeleteModalBtn" class="flex-1 rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300 dark:hover:bg-slate-700">
                    Cancel
                </button>
                <button type="button" id="confirmDeleteBtn" class="flex-1 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-bold text-white shadow-md transition hover:bg-red-700 hover:shadow-lg">
                    Delete
                </button>
            </div>
        </div>
    </div>
</x-admin.layout>