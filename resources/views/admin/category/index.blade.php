<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Vehicle Categories
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="layers-3" class="h-4 w-4"></i>
                        Manage your fleet labels seamlessly on a single dashboard workspace.
                    </p>
                </div>
            </div>
        </div>

        <div id="alertContainer" class="mb-5 space-y-3">
            <div id="successBox"
                class="hidden rounded-xl border border-green-200 bg-green-50 p-4 dark:border-green-900 dark:bg-green-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="check-circle" class="h-5 w-5 flex-shrink-0 text-green-600 dark:text-green-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-green-800 dark:text-green-200">Success!</h3>
                        <p id="successText" class="mt-1 text-sm text-green-700 dark:text-green-300"></p>
                    </div>
                    <button type="button"
                        class="close-alert text-green-500 hover:text-green-700 dark:hover:text-green-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>

            <div id="errorBox"
                class="hidden rounded-xl border border-red-200 bg-red-50 p-4 dark:border-red-900 dark:bg-red-950">
                <div class="flex items-start gap-3">
                    <i data-lucide="x-circle" class="h-5 w-5 flex-shrink-0 text-red-600 dark:text-red-400"></i>
                    <div class="flex-1">
                        <h3 class="font-semibold text-red-800 dark:text-red-200">Action Blocked</h3>
                        <p id="errorText" class="mt-1 text-sm text-red-700 dark:text-green-300"></p>
                    </div>
                    <button type="button" class="close-alert text-red-500 hover:text-red-700 dark:hover:text-red-300">
                        <i data-lucide="x" class="h-4 w-4"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <section
                class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                <div class="mb-5 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white">Active Categories</h2>

                    <div class="relative w-full sm:w-64">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-3 text-slate-400 dark:text-slate-500">
                            <i data-lucide="search" class="h-4 w-4"></i>
                        </span>
                        <input type="text" id="tableSearchInput" placeholder="Search categories..."
                            class="h-9 w-full rounded-xl border border-slate-300 bg-white pl-9 pr-4 text-xs font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="border-b border-slate-200 dark:border-slate-700 text-xs font-semibold uppercase text-slate-400 tracking-wider">
                                <th class="py-3 px-4 w-16">No</th>
                                <th class="py-3 px-4">Name</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="categoriesTableBody"
                            class="divide-y divide-slate-100 dark:divide-slate-700/50 text-sm text-slate-700 dark:text-slate-300">
                            <tr>
                                <td colspan="3" class="py-6 text-center text-slate-400">Loading fleet records...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>

            <aside class="space-y-6">
                <section
                    class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <div class="mb-4 flex items-center gap-3">
                        <div
                            class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-500/10 text-cyan-600 dark:text-cyan-300">
                            <i id="formIcon" data-lucide="folder-plus" class="h-5 w-5"></i>
                        </div>
                        <div>
                            <h3 id="formTitle" class="text-base font-bold text-slate-900 dark:text-white">New Category
                            </h3>
                            <p id="formSubtitle" class="text-xs text-slate-500">Add a unique classification label.</p>
                        </div>
                    </div>

                    <form id="categoryForm" class="space-y-4">
                        <input type="hidden" id="category_id" value="">
                        <div>
                            <label for="category_name"
                                class="mb-1.5 block text-xs font-semibold text-slate-600 dark:text-slate-400">Category
                                Name</label>
                            <input type="text" id="category_name" placeholder="Example: SUV, Sedan, Van" required
                                class="h-11 w-full rounded-xl border border-slate-300 bg-white px-4 text-sm font-medium text-slate-800 shadow-sm transition focus:border-cyan-500 focus:outline-none focus:ring-4 focus:ring-cyan-500/20 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
                        </div>

                        <div class="flex gap-2 pt-2">
                            <button type="button" id="cancelBtn"
                                class="hidden w-1/3 h-10 text-xs font-bold rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                                Cancel
                            </button>
                            <button type="submit" id="saveBtn"
                                class="w-full h-10 text-xs font-bold text-white rounded-xl bg-gradient-to-r from-cyan-500 to-blue-600 shadow-md transition hover:-translate-y-0.5">
                                Save Record
                            </button>
                        </div>
                    </form>
                </section>
            </aside>
        </div>
    </div>

    <div id="deleteConfirmationModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
        <div
            class="relative w-full max-w-md transform overflow-hidden rounded-2xl bg-white p-6 shadow-xl transition-all dark:bg-slate-800 border border-slate-200 dark:border-slate-700 animate-in fade-in zoom-in-95 duration-200">
            <div class="flex flex-col items-center text-center">
                <div
                    class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 mb-4">
                    <i data-lucide="alert-triangle" class="h-6 w-6"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Confirm Removal</h3>
                <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Are you completely sure you want to remove
                    this vehicle category? This action cannot be undone.</p>
            </div>
            <div class="mt-6 flex justify-end gap-3">
                <button type="button" id="closeDeleteModalBtn"
                    class="px-4 h-10 text-xs font-bold rounded-xl border border-slate-200 text-slate-600 transition hover:bg-slate-50 dark:border-slate-700 dark:text-slate-300">
                    Keep Record
                </button>
                <button type="button" id="confirmDeleteBtn"
                    class="px-5 h-10 text-xs font-bold text-white rounded-xl bg-red-600 hover:bg-red-700 shadow-md transition">
                    Delete Permanently
                </button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // DOM Elements references
                const $tableBody = $('#categoriesTableBody');
                const $form = $('#categoryForm');
                const $categoryIdInput = $('#category_id');
                const $categoryNameInput = $('#category_name');
                const $saveBtn = $('#saveBtn');
                const $cancelBtn = $('#cancelBtn');
                const $formTitle = $('#formTitle');
                const $formSubtitle = $('#formSubtitle');
                const $searchInput = $('#tableSearchInput');

                // Alerts Elements
                const $successBox = $('#successBox');
                const $successText = $('#successText');
                const $errorBox = $('#errorBox');
                const $errorText = $('#errorText');

                // Modal Context Pointer Objects
                const $deleteModal = $('#deleteConfirmationModal');
                const $confirmDeleteBtn = $('#confirmDeleteBtn');
                const $closeDeleteModalBtn = $('#closeDeleteModalBtn');
                let targetDeleteId = null;

                // ⭐ UPDATED: Cookie/Session Base AJAX Headers Factory with CSRF protection
                const getHeaders = () => ({
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // layout ထဲက token လှမ်းယူတာပါ
                });

                // ⭐ UPDATED: Universal Error Handler for State Session check
                function handleAjaxError(xhr, fallbackMessage) {
                    if (xhr.status === 401) {
                        // Clear up and route back to login if session ends or expires
                        window.location.href = "{{ url('/login') }}";
                    } else {
                        const msg = xhr.responseJSON?.message || fallbackMessage;
                        showAlert('error', msg);
                    }
                }

                function refreshIcons() {
                    if (typeof window.initLucideIcons === 'function') {
                        window.initLucideIcons();
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

                // LIVE REAL-TIME SEARCH BOX ENGINE
                $searchInput.on('keyup', function() {
                    const queryValue = $(this).val().toLowerCase().trim();
                    let visibleRowsCount = 0;

                    $('#noSearchResultsRow').remove();

                    $tableBody.find('tr').each(function() {
                        if ($(this).find('td').attr('colspan')) return;
                        const nameCellText = $(this).find('td').eq(1).text().toLowerCase();

                        if (nameCellText.indexOf(queryValue) > -1) {
                            $(this).show();
                            visibleRowsCount++;
                        } else {
                            $(this).hide();
                        }
                    });

                    if (visibleRowsCount === 0 && queryValue !== '') {
                        $tableBody.append(`
                            <tr id="noSearchResultsRow">
                                <td colspan="3" class="py-8 text-center text-slate-400 dark:text-slate-500">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <i data-lucide="search-x" class="h-5 w-5 text-slate-300 dark:text-slate-600"></i>
                                        <span>No categories match "${$(this).val()}"</span>
                                    </div>
                                </td>
                            </tr>
                        `);
                        refreshIcons();
                    }
                });

                // 1. READ ACTION: Load Categories from Database
                function loadCategories() {
                    $.ajax({
                        url: "{{ url('/api/categories') }}",
                        method: 'GET',
                        headers: getHeaders(),
                        dataType: 'json',
                        success: function(result) {
                            let rows = '';

                            if (!result.data || result.data.length === 0) {
                                rows =
                                    `<tr><td colspan="3" class="py-6 text-center text-slate-400">No active categories found.</td></tr>`;
                            } else {
                                result.data.forEach((category, index) => {
                                    rows += `
                                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-700/20 transition-colors">
                                            <td class="py-3 px-4 font-semibold text-slate-400 dark:text-slate-500">${index + 1}</td>
                                            <td class="py-3 px-4 font-medium text-slate-900 dark:text-white">${category.name}</td>
                                            <td class="py-3 px-4 text-right space-x-1">
                                                <button data-id="${category.id}" data-name="${category.name}" class="edit-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-cyan-600 hover:border-cyan-500 hover:bg-cyan-50 dark:border-slate-700 dark:bg-slate-900">
                                                    <i class="h-4 w-4" data-lucide="pencil"></i>
                                                </button>
                                                <button data-id="${category.id}" class="delete-btn inline-flex items-center justify-center h-8 w-8 rounded-lg border border-slate-200 bg-white text-red-500 hover:border-red-500 hover:bg-red-50 dark:border-slate-700 dark:bg-slate-900">
                                                    <i class="h-4 w-4" data-lucide="trash-2"></i>
                                                </button>
                                            </td>
                                        </tr>`;
                                });
                            }
                            $tableBody.html(rows);
                            $searchInput.val('');
                            refreshIcons();
                        },
                        error: function(xhr) {
                            handleAjaxError(xhr, 'Failed to fetch categories.');
                        }
                    });
                }

                // 2. CREATE & UPDATE ACTIONS: Form Handler
                $form.on('submit', function(e) {
                    e.preventDefault();

                    const id = $categoryIdInput.val();
                    const name = $categoryNameInput.val().trim();

                    // ⭐ API Endpoint Mapping for Stateful Sanctum Routing
                    const url = id ? `{{ url('/api/categories') }}/${id}` : '{{ url('/api/categories') }}';
                    const method = id ? 'PUT' : 'POST';

                    $.ajax({
                        url: url,
                        method: method,
                        headers: getHeaders(),
                        contentType: 'application/json',
                        dataType: 'json',
                        data: JSON.stringify({
                            name: name
                        }),
                        success: function(response) {
                            resetForm();
                            loadCategories();
                            const localizedMsg = id ? 'Category updated successfully.' :
                                'Category created successfully.';
                            showAlert('success', response.message || localizedMsg);
                        },
                        error: function(xhr) {
                            handleAjaxError(xhr, 'Validation or processing error.');
                        }
                    });
                });

                // 3. UI STATE CONTROL: Click Handler for Dynamic Row Buttons
                $tableBody.on('click', 'button', function(e) {
                    const $button = $(this);
                    const id = $button.attr('data-id');

                    if ($button.hasClass('edit-btn')) {
                        const name = $button.attr('data-name');
                        $categoryIdInput.val(id);
                        $categoryNameInput.val(name);

                        $formTitle.text('Edit Category');
                        $formSubtitle.text(`Modifying entry identity #${id}`);
                        $saveBtn.text('Update Changes');

                        $cancelBtn.removeClass('hidden');
                        $saveBtn.removeClass('w-full').addClass('w-2/3');
                    } else if ($button.hasClass('delete-btn')) {
                        targetDeleteId = id;
                        $deleteModal.removeClass('hidden').addClass('flex');
                    }
                });

                function hideDeleteModal() {
                    $deleteModal.addClass('hidden').removeClass('flex');
                    targetDeleteId = null;
                }

                $closeDeleteModalBtn.on('click', hideDeleteModal);

                $confirmDeleteBtn.on('click', function() {
                    if (targetDeleteId) {
                        executeDelete(targetDeleteId);
                    }
                });

                // 4. DELETE ACTION
                function executeDelete(id) {
                    $.ajax({
                        url: `{{ url('/api/categories') }}/${id}`,
                        method: 'DELETE',
                        headers: getHeaders(),
                        dataType: 'json',
                        success: function(response) {
                            hideDeleteModal();
                            loadCategories();
                            showAlert('success', response.message || 'Category deleted successfully.');
                        },
                        error: function(xhr) {
                            hideDeleteModal();
                            handleAjaxError(xhr, 'Could not execute target delete.');
                        }
                    });
                }

                function resetForm() {
                    $form[0].reset();
                    $categoryIdInput.val('');
                    $formTitle.text('New Category');
                    $formSubtitle.text('Add a unique classification label.');
                    $saveBtn.text('Save Record');

                    $cancelBtn.addClass('hidden');
                    $saveBtn.removeClass('w-2/3').addClass('w-full');
                }

                $cancelBtn.on('click', resetForm);

                // Initial setup and execution load
                loadCategories();
                refreshIcons();
            });
        </script>
    @endpush
</x-admin.layout>
