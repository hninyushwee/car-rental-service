import { refreshIcons } from './icons';

export function bindTableSearch({ input, tableBody, columnIndex = 1, emptyRowId = 'noSearchResultsRow' }) {
    if (!input || !tableBody) return;

    input.addEventListener('input', () => {
        const query = input.value.toLowerCase().trim();
        let visibleRows = 0;

        document.getElementById(emptyRowId)?.remove();

        tableBody.querySelectorAll('tr').forEach((row) => {
            if (row.querySelector('td[colspan]')) return;

            const text = row.children[columnIndex]?.textContent.toLowerCase() || '';
            const matches = text.includes(query);

            row.classList.toggle('hidden', !matches);
            if (matches) visibleRows += 1;
        });

        if (visibleRows === 0 && query !== '') {
            tableBody.insertAdjacentHTML('beforeend', `
                <tr id="${emptyRowId}">
                    <td colspan="3" class="py-8 text-center text-slate-400 dark:text-slate-500">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <i data-lucide="search-x" class="h-5 w-5 text-slate-300 dark:text-slate-600"></i>
                            <span>No records match "${input.value}"</span>
                        </div>
                    </td>
                </tr>
            `);
            refreshIcons();
        }
    });
}
