import $ from 'jquery';
import { jsonRequest } from '../common/http';
import { notify } from '../common/notify';

function escapeHtml(value) {
    return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;').replace(/'/g, '&#039;');
}

function refreshIcons() { window.initLucideIcons?.(); }

function statusBadge(status) {
    const map = {
        open: 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400',
        resolved: 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400',
        closed: 'bg-slate-100 text-slate-800 dark:bg-slate-700 dark:text-slate-300',
    };
    return `<span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-medium ${map[status] || map.open}">${escapeHtml(status)}</span>`;
}

function renderInquiry(inquiry) {
    const statusOptions = ['open', 'resolved'].map(s =>
        `<option value="${s}" ${inquiry.status === s ? 'selected' : ''}>${s}</option>`
    ).join('');

    return `
        <div class="mb-4">
            <a href="/admin/inquiries" class="inline-flex items-center gap-1 text-sm text-cyan-600 hover:text-cyan-700 dark:text-cyan-400">
                <i data-lucide="arrow-left" class="h-4 w-4"></i> Back to Inquiries
            </a>
        </div>
        <div class="mb-5 rounded-xl border border-cyan-500/20 bg-gradient-to-br from-cyan-500/10 via-blue-500/5 to-purple-500/10 px-4 py-3 dark:border-cyan-500/10 sm:px-5 sm:py-4">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h1 class="bg-gradient-to-r from-cyan-600 to-blue-600 bg-clip-text text-lg font-bold text-transparent dark:from-cyan-400 dark:to-blue-400 sm:text-xl">${escapeHtml(inquiry.subject)}</h1>
                    <p class="mt-0.5 text-sm text-slate-600 dark:text-slate-400">${escapeHtml(inquiry.user?.name || 'Unknown')} | ${escapeHtml(inquiry.created_at?.split('T')[0] || '')}</p>
                </div>
                <div class="flex items-center gap-3">
                    <select id="inquiryStatusSelect" class="rounded-lg border border-slate-300 bg-white px-3 py-1.5 text-xs font-medium dark:border-slate-600 dark:bg-slate-700 dark:text-white">${statusOptions}</select>
                    <button type="button" id="updateStatusBtn" class="rounded-lg bg-cyan-400 px-4 py-1.5 text-xs font-medium text-black hover:bg-cyan-500">Update</button>
                </div>
            </div>
        </div>
        <div class="rounded-2xl border border-slate-200/60 bg-white/90 p-6 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">User Message</h3>
            <div class="prose prose-sm max-w-none dark:prose-invert">
                ${escapeHtml(inquiry.message).replace(/\n/g, '<br>')}
            </div>
        </div>

        ${inquiry.admin_response ? `
        <div class="mt-4 rounded-2xl border border-emerald-200/60 bg-emerald-50/80 p-6 shadow-xl dark:border-emerald-800/60 dark:bg-emerald-950/30">
            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400">Your Response</h3>
            <div class="prose prose-sm max-w-none dark:prose-invert text-emerald-800 dark:text-emerald-200">
                ${escapeHtml(inquiry.admin_response).replace(/\n/g, '<br>')}
            </div>
        </div>` : ''}

        <div class="mt-4 rounded-2xl border border-slate-200/60 bg-white/90 p-6 shadow-xl dark:border-slate-700/60 dark:bg-slate-800/90">
            <h3 class="mb-3 text-xs font-bold uppercase tracking-wider text-slate-500 dark:text-slate-400">${inquiry.admin_response ? 'Update Response' : 'Write Response'}</h3>
            <textarea id="adminResponseInput" rows="5" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 placeholder-slate-400 focus:border-cyan-500 focus:outline-none focus:ring-2 focus:ring-cyan-500/20 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-500">${escapeHtml(inquiry.admin_response || '')}</textarea>
        </div>`;
}

function initInquiryShowPage() {
    const $page = $('[data-page="admin-inquiry-show"]');
    if (!$page.length || $page.data('initialized')) return;

    const apiBase = $page.data('api-base');
    const inquiryId = window.location.pathname.split('/').pop();
    const $loading = $('#loadingState');
    const $content = $('#inquiryContent');
    const $error = $('#errorState');
    const $errorMsg = $('#errorMessage');

    let currentSubject = '';
    let currentMessage = '';

    function bindUpdateBtn() {
        $('#updateStatusBtn').on('click', async function () {
            const status = $('#inquiryStatusSelect').val();
            const adminResponse = $('#adminResponseInput').val().trim();
            const $btn = $(this).prop('disabled', true).text('Saving...');
            try {
                const payload = await jsonRequest(`${apiBase}/${inquiryId}`, {
                    method: 'PUT',
                    body: { status, subject: currentSubject, message: currentMessage, admin_response: adminResponse || null },
                });
                const updated = payload?.data || payload;
                currentSubject = updated.subject || currentSubject;
                currentMessage = updated.message || currentMessage;
                $content.html(renderInquiry(updated)).removeClass('hidden');
                refreshIcons();
                bindUpdateBtn();
                notify('Inquiry updated successfully');
            } catch (err) {
                $btn.prop('disabled', false).text('Update');
                notify(err.message || 'Update failed.', 'error');
            }
        });
    }

    async function load() {
        try {
            const payload = await jsonRequest(`${apiBase}/${inquiryId}`);
            const inquiry = payload?.data || payload;
            if (!inquiry || !inquiry.id) throw new Error('Inquiry not found');
            currentSubject = inquiry.subject || '';
            currentMessage = inquiry.message || '';
            $loading.addClass('hidden');
            $content.html(renderInquiry(inquiry)).removeClass('hidden');
            refreshIcons();
            bindUpdateBtn();
        } catch (err) {
            $loading.addClass('hidden');
            $errorMsg.text(err.message);
            $error.removeClass('hidden');
        }
    }

    $page.data('initialized', true);
    load();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="admin-inquiry-show"]')) initInquiryShowPage();
});
