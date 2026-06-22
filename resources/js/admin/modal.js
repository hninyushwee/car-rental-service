export function createConfirmModal({ modal, confirmButton, closeButton }) {
    let pendingId = null;

    function open(id) {
        pendingId = id;
        modal?.classList.remove('hidden');
        modal?.classList.add('flex');
    }

    function close() {
        pendingId = null;
        modal?.classList.add('hidden');
        modal?.classList.remove('flex');
    }

    closeButton?.addEventListener('click', close);

    return {
        open,
        close,
        onConfirm(callback) {
            confirmButton?.addEventListener('click', () => {
                if (pendingId) callback(pendingId);
            });
        },
    };
}
