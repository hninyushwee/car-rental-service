<x-admin.layout>
    <div data-page="admin-staff-form" data-api-base="{{ url('/api/admin/staff') }}" data-permissions-url="{{ url('/api/admin/permissions') }}" data-roles-url="{{ url('/api/admin/roles') }}" data-staff-id="{{ $staffId }}" data-is-edit="{{ json_encode($isEdit) }}" data-index-url="{{ route('admin.staff.index') }}" data-login-url="{{ route('login') }}" class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">{{ $isEdit ? 'Edit Staff' : 'Create Staff' }}</h1>
                    <p class="mt-0.5 flex items-center gap-2 text-slate-600 dark:text-slate-400">
                        <i data-lucide="{{ $isEdit ? 'edit' : 'user-plus' }}" class="h-3 w-3"></i>
                        <span>{{ $isEdit ? 'Update staff account' : 'Add a new staff member' }}</span>
                    </p>
                </div>
                <a href="{{ route('admin.staff.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="mx-auto max-w-2xl">
            <form id="staffForm" class="space-y-5">
                @csrf
                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Account details</h2>
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                            <input type="text" name="name" id="staffName" placeholder="e.g., Jane Smith" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <span id="nameError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                            <input type="email" name="email" id="staffEmail" placeholder="e.g., jane@example.com" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <span id="emailError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                            <input type="text" name="phone" id="staffPhone" placeholder="e.g., +1 555-123-4567" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <span id="phoneError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                            <input type="password" name="password" id="staffPassword" placeholder="{{ $isEdit ? 'Leave blank to keep current' : 'Min 8 characters' }}" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <span id="passwordError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                        </div>
                    </div>
                </section>

                <section class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm dark:border-slate-700 dark:bg-slate-800">
                    <h2 class="mb-4 text-base font-semibold text-slate-900 dark:text-white">Role &amp; Permissions</h2>
                    <div class="mb-4">
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Role</label>
                        <select name="role" id="staffRole" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm transition hover:border-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white">
                            <option value="">Select a role</option>
                        </select>
                        <span id="roleError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-300">Additional Permissions</label>
                        <div id="permissionsContainer" class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                        </div>
                        <span id="permissionsError" class="input-error-msg mt-1 hidden text-xs font-medium text-red-600 dark:text-red-400"></span>
                    </div>
                </section>

                <div class="flex gap-3">
                    <button type="submit" id="submitFormBtn" class="flex-1 rounded-lg bg-cyan-400 px-5 py-2.5 text-center text-sm font-bold text-black transition hover:bg-cyan-500">
                        {{ $isEdit ? 'Update Staff' : 'Create Staff' }}
                    </button>
                    <a href="{{ route('admin.staff.index') }}" class="flex-1 rounded-lg border border-slate-300 px-5 py-2.5 text-center text-sm font-bold text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:text-slate-300 dark:hover:bg-slate-700">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-admin.layout>
