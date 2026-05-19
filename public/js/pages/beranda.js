/**
 * Beranda Page JS — resources/js/pages/beranda.js
 */

/** Open a modal overlay by ID */
function openModal(id) {
    document.getElementById(id).classList.add('active');
    document.body.style.overflow = 'hidden';
}

/** Close a modal overlay by ID */
function closeModal(id) {
    document.getElementById(id).classList.remove('active');
    document.body.style.overflow = '';
}

/** Populate and open the Edit Lahan modal */
function openEditLahanModal(btn) {
    const id   = btn.dataset.id;
    const form = document.getElementById('edit-lahan-form');

    form.action = `${window.lahanBaseUrl}/${id}`;

    document.getElementById('edit-lahan-id').value    = id;
    document.getElementById('edit-nama-lahan').value  = btn.dataset.nama_lahan  || '';
    document.getElementById('edit-lokasi').value      = btn.dataset.lokasi      || '';
    document.getElementById('edit-lebar').value       = btn.dataset.lebar       || '';
    document.getElementById('edit-panjang').value     = btn.dataset.panjang     || '';
    document.getElementById('edit-keterangan').value  = btn.dataset.keterangan  || '';

    openModal('m-lahan-edit');
}

// Close modal when clicking the backdrop
document.querySelectorAll('.modal-overlay').forEach(overlay => {
    overlay.addEventListener('click', function (e) {
        if (e.target === this) closeModal(this.id);
    });
});

// Re-open modals if there are validation errors
if (window.hasCreateLahanError) openModal('m-lahan');
if (window.hasUpdateLahanError) openModal('m-lahan-edit');
