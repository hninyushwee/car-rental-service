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
                        <textarea name="description" id="vehicleDescription" rows="3" placeholder="Enter vehicle special features..."
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
                            <!-- Compact Image Upload -->
                            <div id="imageUploadArea" class="relative overflow-hidden rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 transition hover:border-cyan-500 hover:bg-cyan-50/50 dark:border-slate-600 dark:bg-slate-700/50 dark:hover:border-cyan-500 dark:hover:bg-cyan-950/20">
                                <input type="file" name="image" id="imageInput" class="sr-only" accept="image/*">
                                
                                <!-- Upload Placeholder (compact) -->
                                <div id="uploadPlaceholder" class="flex items-center justify-center gap-3 py-3 px-4 cursor-pointer">
                                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-cyan-100 dark:bg-cyan-900/50">
                                        <i data-lucide="image-plus" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                                    </div>
                                    <div class="text-left">
                                        <p class="text-sm font-medium text-slate-700 dark:text-slate-300">Upload Image</p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400">PNG, JPG up to 2MB</p>
                                    </div>
                                </div>

                                <!-- File Info (shows when file is selected) - Compact -->
                                <div id="fileInfoContainer" class="hidden">
                                    <div class="flex items-center justify-between gap-2 py-2 px-3">
                                        <div class="flex items-center gap-2 min-w-0">
                                            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-cyan-100 dark:bg-cyan-900/50">
                                                <i data-lucide="file-image" class="h-4 w-4 text-cyan-600 dark:text-cyan-400"></i>
                                            </div>
                                            <div class="min-w-0 flex-1">
                                                <p id="fileNameDisplay" class="truncate text-xs font-medium text-slate-700 dark:text-slate-300"></p>
                                                <p id="fileSizeDisplay" class="text-[10px] text-slate-500 dark:text-slate-400"></p>
                                            </div>
                                        </div>
                                        <button type="button" id="removeImageBtn" class="shrink-0 rounded-lg p-1 text-slate-400 hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-950/50 dark:hover:text-red-400 transition-colors" title="Remove image">
                                            <i data-lucide="x" class="h-3.5 w-3.5"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
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
                            <p id="previewDescription" class="mt-2 text-xs text-slate-600 dark:text-slate-400 line-clamp-3 min-h-[2rem] leading-relaxed">
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
        <!-- Toastify-JS for Toast Notifications -->
        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize VanillaJS-Datepicker for Year Selection (ant design style layout)
                let datepickerInstance = null;
                const yearPickerEl = document.querySelector('.year-picker');
                if (yearPickerEl && window.Datepicker) {
                    datepickerInstance = new window.Datepicker(yearPickerEl, {
                        pickLevel: 2, // Year selector only (0: date, 1: month, 2: year)
                        format: 'yyyy',
                        autohide: true,
                        startView: 2,
                        maxView: 2
                    });
                }

                const brandInput = document.getElementById('vehicleBrand');
                const modelInput = document.getElementById('vehicleModel');
                const categorySelect = document.getElementById('vehicleCategory');
                const priceInput = document.getElementById('vehiclePrice');
                const imageInput = document.getElementById('imageInput');
                const descriptionInput = document.getElementById('vehicleDescription');

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
                
                // Description live preview
                descriptionInput?.addEventListener('input', function() {
                    const previewDesc = document.getElementById('previewDescription');
                    const text = this.value.trim();
                    previewDesc.innerText = text || 'No description provided yet.';
                    // Update line clamp based on content length
                    if (text.length > 100) {
                        previewDesc.classList.remove('line-clamp-3');
                        previewDesc.classList.add('line-clamp-5');
                    } else {
                        previewDesc.classList.remove('line-clamp-5');
                        previewDesc.classList.add('line-clamp-3');
                    }
                });

                // Handle image selection - show only file name and size (compact)
                function handleImageFile(file) {
                    if (!file) return;
                    
                    // Validate file size (2MB max)
                    if (file.size > 2 * 1024 * 1024) {
                        showToast('Image size must be less than 2MB', 'error');
                        imageInput.value = '';
                        return;
                    }
                    
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        showToast('Please upload a valid image (PNG, JPG)', 'error');
                        imageInput.value = '';
                        return;
                    }
                    
                    // Show file info
                    const fileInfoContainer = document.getElementById('fileInfoContainer');
                    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
                    const fileNameDisplay = document.getElementById('fileNameDisplay');
                    const fileSizeDisplay = document.getElementById('fileSizeDisplay');
                    
                    // Format file size
                    let fileSize = file.size;
                    let sizeText = '';
                    if (fileSize < 1024) {
                        sizeText = fileSize + ' B';
                    } else if (fileSize < 1024 * 1024) {
                        sizeText = (fileSize / 1024).toFixed(1) + ' KB';
                    } else {
                        sizeText = (fileSize / (1024 * 1024)).toFixed(1) + ' MB';
                    }
                    
                    fileNameDisplay.textContent = file.name;
                    fileSizeDisplay.textContent = sizeText;
                    
                    uploadPlaceholder.classList.add('hidden');
                    fileInfoContainer.classList.remove('hidden');
                    
                    // Also update the preview image in the sidebar
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        const sidebarPreviewImg = document.getElementById('previewImg');
                        const previewIcon = document.getElementById('previewIcon');
                        sidebarPreviewImg.src = e.target.result;
                        sidebarPreviewImg.classList.remove('hidden');
                        previewIcon.classList.add('hidden');
                    };
                    reader.readAsDataURL(file);
                    
                    lucide.createIcons();
                }

                imageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        handleImageFile(file);
                    }
                });

                // Remove image button
                const removeImageBtn = document.getElementById('removeImageBtn');
                if (removeImageBtn) {
                    removeImageBtn.addEventListener('click', function(e) {
                        e.stopPropagation();
                        imageInput.value = '';
                        document.getElementById('fileInfoContainer').classList.add('hidden');
                        document.getElementById('uploadPlaceholder').classList.remove('hidden');
                        document.getElementById('previewImg').classList.add('hidden');
                        document.getElementById('previewImg').src = '';
                        document.getElementById('previewIcon').classList.remove('hidden');
                        lucide.createIcons();
                    });
                }

                // Drag and drop functionality
                const imageUploadArea = document.getElementById('imageUploadArea');
                if (imageUploadArea) {
                    imageUploadArea.addEventListener('dragover', function(e) {
                        e.preventDefault();
                        this.classList.add('border-cyan-500', 'bg-cyan-50/50', 'dark:bg-cyan-950/20');
                    });

                    imageUploadArea.addEventListener('dragleave', function(e) {
                        e.preventDefault();
                        this.classList.remove('border-cyan-500', 'bg-cyan-50/50', 'dark:bg-cyan-950/20');
                    });

                    imageUploadArea.addEventListener('drop', function(e) {
                        e.preventDefault();
                        this.classList.remove('border-cyan-500', 'bg-cyan-50/50', 'dark:bg-cyan-950/20');
                        const file = e.dataTransfer.files[0];
                        if (file && file.type.startsWith('image/')) {
                            imageInput.files = e.dataTransfer.files;
                            handleImageFile(file);
                        } else {
                            showToast('Please drop a valid image file', 'error');
                        }
                    });

                    imageUploadArea.addEventListener('click', function(e) {
                        // Don't trigger if clicking on remove button
                        if (!e.target.closest('#removeImageBtn')) {
                            imageInput.click();
                        }
                    });
                }

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
                                document.getElementById('previewImg').classList.add('hidden');
                                document.getElementById('previewImg').src = '';
                                document.getElementById('previewIcon').classList.remove('hidden');
                                
                                // Reset file upload
                                document.getElementById('fileInfoContainer').classList.add('hidden');
                                document.getElementById('uploadPlaceholder').classList.remove('hidden');
                                document.getElementById('fileNameDisplay').textContent = '';
                                document.getElementById('fileSizeDisplay').textContent = '';
                                
                                // Reset datepicker instance
                                if (datepickerInstance) {
                                    datepickerInstance.clear();
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