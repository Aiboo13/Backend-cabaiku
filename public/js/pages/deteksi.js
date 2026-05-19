/**
 * Deteksi Page JS — resources/js/pages/deteksi.js
 */

/** Show image preview after file selection */
function previewImg(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('upload-area').style.display  = 'none';
            document.getElementById('preview-area').style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/** Remove the selected image preview */
function removePreview() {
    document.getElementById('gambar-inp').value = '';
    document.getElementById('upload-area').style.display  = 'block';
    document.getElementById('preview-area').style.display = 'none';
}

/** Highlight the selected lahan option */
function selLahan(id) {
    document.querySelectorAll('.lahan-opt').forEach(c => c.classList.remove('sel'));
    document.querySelectorAll('[id^="chk-"]').forEach(i => i.style.opacity = '0');
    document.getElementById('lo-' + id).classList.add('sel');
    document.getElementById('chk-' + id).style.opacity = '1';
}

// Drag-and-drop support
const dz = document.getElementById('drop-zone');
if (dz) {
    dz.addEventListener('dragover', e => { e.preventDefault(); dz.classList.add('dragover'); });
    dz.addEventListener('dragleave', () => dz.classList.remove('dragover'));
    dz.addEventListener('drop', e => {
        e.preventDefault();
        dz.classList.remove('dragover');
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            document.getElementById('gambar-inp').files = files;
            previewImg(document.getElementById('gambar-inp'));
        }
    });
}

// Prevent double-submit
let isSubmitting = false;
document.getElementById('deteksi-form')?.addEventListener('submit', function (e) {
    if (isSubmitting) { e.preventDefault(); return; }
    isSubmitting = true;
    const btn = document.getElementById('submit-btn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Sedang Menganalisis...';
    btn.disabled  = true;
});
