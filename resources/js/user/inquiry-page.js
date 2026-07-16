import $ from 'jquery';
import { jsonRequest } from '../admin/common/http';

function initInquiryPage() {
    const $page = $('[data-page="user-inquiry"]');
    if (!$page.length || $page.data('initialized')) return;

    const $form = $('#inquiryForm');
    const $subjectInput = $form.find('[name="subject"]');
    const $messageInput = $form.find('[name="message"]');
    const $submitBtn = $form.find('[type="submit"]');
    const $list = $('#inquiriesList');
    const $count = $('#inquiryCount');
    const $toast = $('#demoToast');

    function showToast(message, isError) {
        $toast.text(message)
            .attr('class', `fixed bottom-5 right-5 z-50 rounded-xl px-5 py-3 text-sm font-bold text-white shadow-xl transition-all duration-300 ${isError ? 'bg-rose-600' : 'bg-gradient-to-r from-green-500 to-green-600'}`)
            .removeClass('hidden');
        setTimeout(() => $toast.addClass('hidden'), 3500);
    }

    function escapeHtml(value) {
        return String(value ?? '').replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

    async function loadInquiries() {
        try {
            const payload = await jsonRequest('/api/user/inquiries?per_page=3');
            const data = payload?.data?.data || payload?.data || [];
            const count = payload?.data?.total || data.length;
            $count.text(`${count} total`);
            if (!Array.isArray(data) || !data.length) {
                $list.html('<p class="py-8 text-center text-sm text-slate-400">No inquiries yet.</p>');
                return;
            }
            const statusColors = {
                open: 'bg-yellow-100 text-yellow-800',
                resolved: 'bg-green-100 text-green-800',
                closed: 'bg-slate-100 text-slate-800',
            };
            $list.html(data.map(item => `
                <div class="rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-sm font-semibold text-slate-900">${escapeHtml(item.subject || item.name || 'Inquiry')}</p>
                            <p class="mt-1 text-xs text-slate-500">Submitted: ${new Date(item.created_at).toLocaleDateString()}</p>
                        </div>
                        <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ${statusColors[item.status] || 'bg-slate-100 text-slate-800'}">${item.status}</span>
                    </div>
                    <p class="mt-2 text-sm text-slate-600">${escapeHtml(item.message)}</p>
                    ${item.admin_response ? `<div class="mt-3 rounded-lg bg-slate-50 p-3 text-xs text-slate-600"><span class="font-semibold text-slate-700">Response:</span> ${escapeHtml(item.admin_response)}</div>` : ''}
                </div>
            `).join(''));
        } catch {
            $list.html('<p class="py-8 text-center text-sm text-red-400">Failed to load inquiries.</p>');
        }
    }

    $form.on('submit', async function (e) {
        e.preventDefault();
        $submitBtn.prop('disabled', true).html('Submitting...');

        try {
            await jsonRequest('/api/user/inquiries', {
                method: 'POST',
                body: { subject: $subjectInput.val(), message: $messageInput.val() },
            });
            showToast('Inquiry submitted successfully!');
            $form[0].reset();
            loadInquiries();
        } catch (err) {
            showToast(err.payload?.message || err.message || 'Submission failed', true);
        } finally {
            $submitBtn.prop('disabled', false).html('<i data-lucide="send" class="inline h-5 w-5 mr-2"></i> Submit Inquiry');
        }
    });

    $page.data('initialized', true);
    loadInquiries();
}

$(document).ready(function () {
    if (document.querySelector('[data-page="user-inquiry"]')) initInquiryPage();
});
