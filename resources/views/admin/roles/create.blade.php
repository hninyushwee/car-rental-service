<x-admin.layout>
    <div data-page="admin-role-form" data-api-base="{{ url('/api/admin/roles') }}"
         data-role-id="{{ $roleId }}" data-is-edit="{{ json_encode($isEdit) }}"
         class="p-4 sm:p-6 md:p-8">
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-cyan-400/5 to-cyan-600/10 px-3 py-2 backdrop-blur-sm dark:border-cyan-500/10 sm:px-4 sm:py-2.5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-base font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-lg">{{ $isEdit ? 'Edit Role' : 'Create Role' }}
                    </h1>
                    <p class="mt-0.5 text-slate-600 dark:text-slate-400">
                        <i data-lucide="shield" class="inline h-3 w-3"></i>
                        {{ $isEdit ? 'Update role details' : 'Add a new user role' }}
                    </p>
                </div>
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-2 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-50 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:hover:bg-slate-700">
                    <i data-lucide="arrow-left" class="h-3 w-3"></i>
                    Back
                </a>
            </div>
        </div>
        <div id="formContainer" class="rounded-2xl border border-slate-200/60 bg-white/90 p-6 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <p class="text-center text-slate-400">Form loading...</p>
        </div>
    </div>
</x-admin.layout>
