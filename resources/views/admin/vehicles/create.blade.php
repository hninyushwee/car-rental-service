<x-admin.layout>
    <div class="p-4 sm:p-6 md:p-8">
        <!-- Header Section -->
        <div class="mb-5 rounded-xl bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 sm:px-5 sm:py-4 backdrop-blur-sm border border-cyan-500/20 dark:border-cyan-500/10">
            <div class="flex items-center justify-between flex-wrap gap-3">
                <div>
                    <h1 class="text-xl sm:text-2xl font-bold bg-gradient-to-r from-cyan-600 to-blue-600 dark:from-cyan-400 dark:to-blue-400 bg-clip-text text-transparent">
                        Add New Vehicle
                    </h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400 flex items-center gap-2">
                        <i data-lucide="plus-circle" class="h-4 w-4"></i>
                        Create a new vehicle for your fleet
                    </p>
                </div>
                <a href="{{ route('admin.vehicles.index') }}"
                    class="flex items-center gap-2 rounded-lg border border-slate-300 dark:border-slate-600 px-3 py-2 text-sm font-medium text-slate-700 dark:text-slate-300 transition hover:bg-slate-50 dark:hover:bg-slate-700 bg-white dark:bg-slate-800">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1fr_22rem]">
            <form id="vehicleForm" class="space-y-5" enctype="multipart/form-data">
                @csrf

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Basic Information</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Brand</label>
                            <select name="brand_id" id="vehicleBrand"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">Loading Brands...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Model</label>
                            <input type="text" name="model" id="vehicleModel" placeholder="e.g., 7 Series"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Year</label>
                            <input type="text" name="year" id="vehicleYear" placeholder="Select Year"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white cursor-pointer year-picker">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">License Plate</label>
                            <input type="text" name="license_plate" placeholder="YGN-2048"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Color</label>
                            <input type="text" name="color" placeholder="e.g., Metallic Black"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Capacity (Seats)</label>
                            <input type="number" name="capacity" placeholder="e.g., 5"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Category</label>
                            <select name="category_id" id="vehicleCategory"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="">Loading Categories...</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Status</label>
                            <select name="status"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                                <option value="available">Available</option>
                                <option value="rented">Rented</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Description</label>
                        <textarea name="description" rows="3" placeholder="Enter vehicle special features..."
                            class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white"></textarea>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Pricing & Media</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Price Per Day ($)</label>
                            <input type="number" step="0.01" name="price_per_day" id="vehiclePrice" placeholder="150.00"
                                class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">Vehicle Image</label>
                            <label class="flex h-[42px] cursor-pointer items-center justify-center gap-2 rounded-lg border-2 border-dashed border-slate-300 px-4 text-sm text-slate-600 transition hover:border-cyan-500 hover:text-cyan-600 dark:border-slate-600 dark:text-slate-400 dark:hover:border-cyan-500">
                                <i data-lucide="upload-cloud" class="h-4 w-4"></i>
                                <span>Choose image</span>
                                <input type="file" name="image" id="imageInput" class="sr-only" accept="image/*">
                            </label>
                            <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">PNG, JPG up to 2MB</p>
                        </div>
                    </div>
                </section>

                <div class="flex gap-3">
                    <button type="submit"
                        class="flex-1 rounded-lg bg-gradient-to-r from-cyan-500 to-blue-600 px-5 py-2.5 text-center text-sm font-bold text-white shadow-lg transition hover:shadow-xl">
                        Add Vehicle
                    </button>
                    <button type="button" onclick="window.location.reload()"
                        class="flex-1 rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                        Cancel
                    </button>
                </div>
            </form>

            <aside class="lg:sticky lg:top-20 lg:self-start">
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h3 class="mb-4 text-base font-bold text-slate-900 dark:text-white">Live Preview</h3>
                    <article class="overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-900 shadow-inner">
                        <div class="relative overflow-hidden aspect-video bg-gradient-to-br from-cyan-400 to-blue-600 flex items-center justify-center">
                            <img id="previewImg" src="" class="absolute inset-0 w-full h-full object-cover hidden" alt="Vehicle preview">
                            <i id="previewIcon" data-lucide="car" class="h-16 w-16 text-white opacity-30"></i>
                            <span class="absolute right-3 top-3 rounded-full bg-white/90 dark:bg-slate-800/90 px-2.5 py-1 text-[10px] font-semibold text-slate-800 dark:text-slate-200 backdrop-blur-sm shadow-sm">
                                New
                            </span>
                        </div>
                        <div class="p-4">
                            <h4 id="previewTitle" class="text-lg font-black text-slate-900 dark:text-white truncate">
                                Vehicle Model
                            </h4>
                            <p id="previewCategory" class="mt-1 text-xs text-slate-500 dark:text-slate-400">
                                Not Selected
                            </p>
                            <p id="previewDescription" class="mt-2 text-xs text-slate-600 dark:text-slate-400 line-clamp-2 min-h-[2rem]">
                                No description provided yet.
                            </p>
                            <div class="mt-4 flex items-center justify-between pt-3 border-t border-slate-200 dark:border-slate-700">
                                <div>
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Daily Rate</p>
                                    <p id="previewPrice" class="font-black text-slate-950 dark:text-white text-base">$0.00</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-[10px] text-slate-500 dark:text-slate-400">Deposit (10%)</p>
                                    <p id="previewDeposit" class="font-bold text-cyan-600 dark:text-cyan-400 text-xs">$0.00</p>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
            </aside>
        </div>
    </div>

    @push('scripts')
        <!-- Flatpickr CSS and JS for Calendar Year Picker -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        
        <!-- Toastify-JS for Toast Notifications -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Flatpickr for Year Selection with Calendar
                flatpickr(".year-picker", {
                    dateFormat: "Y",
                    allowInput: true,
                    defaultDate: new Date(),
                    minDate: "1990-01-01",
                    maxDate: new Date().getFullYear().toString(),
                    onChange: function(selectedDates, dateStr, instance) {
                        // Extract just the year from the selected date
                        if (selectedDates[0]) {
                            const year = selectedDates[0].getFullYear();
                            document.getElementById('vehicleYear').value = year;
                        }
                    }
                });

                const brandInput = document.getElementById('vehicleBrand');
                const modelInput = document.getElementById('vehicleModel');
                const categorySelect = document.getElementById('vehicleCategory');
                const priceInput = document.getElementById('vehiclePrice');
                const imageInput = document.getElementById('imageInput');

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $("input[name='_token']").val()
                    }
                });

                // 🟢 Toastify-js Toast Notification configured specifically for Bottom-Left
                function showToast(message, type = 'success') {
                    const isDark = document.documentElement.classList.contains('dark');
                    
                    let backgroundColor;
                    let textColor = '#ffffff';
                    
                    if (type === 'error') {
                        backgroundColor = isDark ? '#7f1d1d' : '#dc2626';
                    } else {
                        backgroundColor = isDark ? '#064e3b' : '#059669';
                    }
                    
                    Toastify({
                        text: message,
                        duration: 4000,
                        close: true,
                        gravity: "bottom",
                        position: "left",
                        stopOnFocus: true,
                        style: {
                            background: backgroundColor,
                            color: textColor,
                            borderRadius: "12px",
                            padding: "12px 20px",
                            fontSize: "14px",
                            fontWeight: "500",
                            boxShadow: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                            fontFamily: "system-ui, -apple-system, sans-serif"
                        },
                        onClick: function() {}
                    }).showToast();
                }

                // Helper to load remote standard datasets into inputs
                function loadDropdownData(apiUrl, selectElement, placeholderText) {
                    $.ajax({
                        url: apiUrl,
                        method: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            const items = response.data || response;
                            let options = `<option value="">Select ${placeholderText}</option>`;
                            $.each(items, function(index, item) {
                                options += `<option value="${item.id}" data-name="${item.name}">${item.name}</option>`;
                            });
                            $(selectElement).html(options);
                        },
                        error: function(xhr) {
                            console.error(`Failed to fetch ${placeholderText} data:`, xhr);
                            $(selectElement).html(`<option value="">Error loading ${placeholderText}</option>`);
                        }
                    });
                }

                loadDropdownData("{{ url('api/brands') }}", brandInput, 'Brand');
                loadDropdownData("{{ url('api/categories') }}", categorySelect, 'Category');

                // Sync UI element values dynamically for the preview sidebar panel
                function updateTextPreview(inputElement, previewId, isDropdown = false, defaultText = '') {
                    const getText = () => {
                        if (isDropdown) {
                            return inputElement.options[inputElement.selectedIndex]?.getAttribute('data-name') || defaultText;
                        }
                        return inputElement.value || defaultText;
                    };
                    document.getElementById(previewId).innerText = getText();
                }

                function updatePricePreview(priceValue) {
                    const price = parseFloat(priceValue) || 0;
                    document.getElementById('previewPrice').innerText = `$${price.toFixed(2)}`;
                    document.getElementById('previewDeposit').innerText = `$${(price * 0.1).toFixed(2)}`;
                }

                const handleTitleInput = () => {
                    const brand = brandInput.options[brandInput.selectedIndex]?.getAttribute('data-name') || 'Vehicle';
                    const model = modelInput.value || 'Model';
                    document.getElementById('previewTitle').innerText = `${brand} ${model}`;
                };

                brandInput.addEventListener('change', handleTitleInput);
                modelInput.addEventListener('input', handleTitleInput);
                categorySelect.addEventListener('change', () => updateTextPreview(categorySelect, 'previewCategory', true, 'Not Selected'));
                priceInput.addEventListener('input', function() { updatePricePreview(this.value); });
                
                const descriptionInput = document.getElementsByName('description')[0];
                descriptionInput?.addEventListener('input', function() {
                    document.getElementById('previewDescription').innerText = this.value || 'No description provided yet.';
                });

                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = (e) => {
                            $(`#previewImg`).attr('src', e.target.result).removeClass('hidden');
                            $(`#previewIcon`).addClass('hidden');
                        }
                        reader.readAsDataURL(file);
                    }
                });

                const $form = $('#vehicleForm');
                const $btn = $form.find('button[type="submit"]');

                // AJAX implementation for managing form submissions safely
                $form.on('submit', function(e) {
                    e.preventDefault();
                    $('.input-error-msg').remove();
                    $('.border-red-500').removeClass('border-red-500');
                    $btn.attr('disabled', true).addClass('opacity-75').text('Processing...');

                    $.ajax({
                        url: "{{ url('/api/vehicles') }}",
                        method: 'POST',
                        data: new FormData(this),
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            $btn.attr('disabled', false).removeClass('opacity-75').text('Add Vehicle');

                            if (response.success) {
                                showToast(response.message || 'Vehicle Added Successfully!', 'success');
                                $form[0].reset();
                                document.getElementById('previewTitle').innerText = 'Vehicle Model';
                                document.getElementById('previewCategory').innerText = 'Not Selected';
                                document.getElementById('previewDescription').innerText = 'No description provided yet.';
                                document.getElementById('previewPrice').innerText = '$0.00';
                                document.getElementById('previewDeposit').innerText = '$0.00';
                                $(`#previewImg`).addClass('hidden').attr('src', '');
                                $(`#previewIcon`).removeClass('hidden');
                                // Reset flatpickr year picker
                                const yearPicker = document.querySelector('.year-picker');
                                if (yearPicker && yearPicker._flatpickr) {
                                    yearPicker._flatpickr.clear();
                                }
                            }
                        },
                        error: function(xhr) {
                            $btn.attr('disabled', false).removeClass('opacity-75').text('Add Vehicle');

                            if (xhr.status === 422) {
                                const errors = xhr.responseJSON?.errors || {};
                                showToast('Please fix the validation errors.', 'error');

                                $.each(errors, function(field, messages) {
                                    const $field = $(`[name="${field}"]`);
                                    $field.addClass('border-red-500');
                                    $field.after(`<p class="input-error-msg mt-1 text-xs text-red-600 font-medium">${messages[0]}</p>`);
                                });
                            } else {
                                showToast(xhr.responseJSON?.message || 'Something went wrong!', 'error');
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
</x-admin.layout>