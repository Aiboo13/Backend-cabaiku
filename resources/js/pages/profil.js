/**
 * Profil Page JS — resources/js/pages/profil.js
 */

/** Toggle collapsible sections */
function toggleSec(id) {
    if (id === 'edit') {
        const sec = document.getElementById('sec-edit');
        sec.style.display = sec.style.display === 'none' ? 'block' : 'none';
        return;
    }
    const body = document.getElementById('body-' + id);
    const chev = document.getElementById('chev-' + id);
    const open = body.classList.toggle('open');
    body.closest('.sec').querySelector('.sec-hd').classList.toggle('open', open);
    if (chev) chev.style.transform = open ? 'rotate(180deg)' : '';
}

/** Select language option */
function selLang(lang) {
    document.getElementById('bahasa-val').value = lang;
    ['id', 'en'].forEach(x => {
        const el = document.getElementById('lo-' + x);
        el.classList.toggle('sel', x === lang);
        el.querySelector('input').checked = (x === lang);
    });
}

// Auto-open sections when there are validation errors
// (flags are set inline in the blade template via window.* variables)
if (window.profilHasNameError || window.profilHasEmailError) {
    document.getElementById('sec-edit').style.display = 'block';
}
if (window.profilHasPasswordError) {
    document.getElementById('body-pw').classList.add('open');
    const chev = document.getElementById('chev-pw');
    if (chev) chev.style.transform = 'rotate(180deg)';
}
