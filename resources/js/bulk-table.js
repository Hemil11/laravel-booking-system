/**
 * Bulk selection: select-all, row checkboxes, floating bar visibility, form submit.
 */
function initBulkRoot(root) {
    const form = root.querySelector('[data-bulk-form]');
    if (!form) {
        return;
    }

    const actionInput = form.querySelector('[data-bulk-action-input]');
    const bar = root.querySelector('[data-bulk-bar]');
    const countEl = root.querySelector('[data-bulk-count]');
    const selectAll = root.querySelector('[data-bulk-select-all]');

    const rowChecks = () => [...root.querySelectorAll('[data-bulk-row]')];

    function syncSelectAllState() {
        const rows = rowChecks();
        const checked = rows.filter((c) => c.checked);
        if (!selectAll) {
            return;
        }
        selectAll.checked = rows.length > 0 && checked.length === rows.length;
        selectAll.indeterminate = checked.length > 0 && checked.length < rows.length;
    }

    function updateBar() {
        const n = rowChecks().filter((c) => c.checked).length;
        if (!bar || !countEl) {
            return;
        }
        if (n > 0) {
            bar.classList.remove('hidden');
            countEl.textContent = String(n);
        } else {
            bar.classList.add('hidden');
        }
        syncSelectAllState();
    }

    selectAll?.addEventListener('change', () => {
        rowChecks().forEach((c) => {
            c.checked = selectAll.checked;
        });
        updateBar();
    });

    root.addEventListener('change', (e) => {
        if (e.target?.matches?.('[data-bulk-row]')) {
            updateBar();
        }
    });

    function selectedCount() {
        return rowChecks().filter((c) => c.checked).length;
    }

    const deleteBtn = root.querySelector('[data-bulk-delete]');
    deleteBtn?.addEventListener('click', () => {
        if (selectedCount() === 0) {
            return;
        }
        const msg = deleteBtn.getAttribute('data-bulk-delete-confirm') || 'Delete selected items?';
        if (!window.confirm(msg)) {
            return;
        }
        if (actionInput) {
            actionInput.value = 'delete';
        }
        form.submit();
    });

    const applyBtn = root.querySelector('[data-bulk-apply-status]');
    applyBtn?.addEventListener('click', () => {
        if (selectedCount() === 0) {
            return;
        }
        const statusSelect = root.querySelector('[data-bulk-status]');
        if (statusSelect && !statusSelect.value) {
            window.alert(statusSelect.getAttribute('data-bulk-status-hint') || 'Choose a status first.');
            return;
        }
        if (actionInput) {
            actionInput.value = 'set_status';
        }
        form.submit();
    });
}

export function initBulkTables() {
    document.querySelectorAll('[data-bulk-root]').forEach(initBulkRoot);
}
