<x-admin.layout>
    <div id="promotionDetailsContainer" data-page="admin-promotion-show" data-id="{{ $promotionId }}"
        data-api-base="{{ url('/api/admin/promotions') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">

        <div id="loadingState" class="py-20">
            <div class="mb-8">
                <div class="skeleton h-3 w-16 mb-3"></div>
                <div class="skeleton h-7 w-48 mb-2"></div>
                <div class="skeleton h-4 w-32"></div>
            </div>
            <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">
                <div class="xl:col-span-2 space-y-6">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="skeleton h-5 w-36 mb-4"></div>
                        <div class="space-y-3">
                            <div class="skeleton h-5 w-full"></div>
                            <div class="skeleton h-5 w-3/4"></div>
                            <div class="skeleton h-5 w-1/2"></div>
                        </div>
                    </div>
                </div>
                <aside class="xl:col-span-1">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                        <div class="skeleton h-5 w-24 mb-4"></div>
                        <div class="space-y-3">
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                            <div class="skeleton h-12 w-full rounded-lg"></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>

        <div id="detailsContent" class="hidden">
            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <a href="{{ route('admin.promotions.index') }}" class="mb-3 inline-flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                        <i data-lucide="arrow-left" class="h-3 w-3"></i>
                        Back
                    </a>
                    <h1 id="promoTitleCode" class="text-2xl font-bold text-slate-900 dark:text-white">Loading...</h1>
                    <p id="promoSubtitleDesc" class="mt-1 text-slate-600 dark:text-slate-400">Promotion Details</p>
                </div>

                <div class="flex flex-wrap gap-3">
                    <span id="statusBadge"></span>
                    @role('super-admin')
                    <a id="editPromoBtn" href="#"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-400 px-4 py-2.5 text-sm font-bold text-black shadow-sm transition hover:bg-cyan-500">
                        <i data-lucide="edit-2" class="h-4 w-4"></i>
                        Edit
                    </a>
                    @endrole
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Promotion Details</h2>
                    <dl class="space-y-3">
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Code</dt>
                            <dd id="promoCode" class="text-sm font-mono font-bold text-slate-900 dark:text-white">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Discount Type</dt>
                            <dd id="promoDiscountType" class="text-sm font-medium text-slate-900 dark:text-white">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Discount Value</dt>
                            <dd id="promoDiscountValue" class="text-sm font-bold text-cyan-600 dark:text-cyan-400">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Min. Spend</dt>
                            <dd id="promoMinSpend" class="text-sm font-medium text-slate-900 dark:text-white">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Max Discount</dt>
                            <dd id="promoMaxDiscount" class="text-sm font-medium text-slate-900 dark:text-white">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">Start Date</dt>
                            <dd id="promoStartDate" class="text-sm font-medium text-slate-900 dark:text-white">-</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-sm text-slate-500 dark:text-slate-400">End Date</dt>
                            <dd id="promoEndDate" class="text-sm font-medium text-slate-900 dark:text-white">-</dd>
                        </div>
                    </dl>
                </section>

                <section class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">Description</h2>
                    <p id="promoDescription" class="text-sm leading-relaxed text-slate-700 dark:text-slate-300">No description provided.</p>
                </section>
            </div>
        </div>

        <div id="errorState" class="hidden py-20 text-center text-red-500 dark:text-red-400">
            <i data-lucide="alert-circle" class="mx-auto mb-2 h-10 w-10"></i>
            <p id="errorMessage" class="font-bold">Failed to load promotion.</p>
            <button type="button" onclick="location.reload()" class="mt-4 rounded-lg bg-cyan-400 px-5 py-2.5 text-sm font-medium text-black">Retry</button>
        </div>
    </div>
</x-admin.layout>
