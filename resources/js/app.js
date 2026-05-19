/**
 * Main App Layout JS — resources/js/app.js
 * Auto-dismiss flash alerts after 4 seconds.
 */
setTimeout(() => {
    document.querySelectorAll('#flash-ok, #flash-err, #flash-info').forEach(el => {
        el.style.transition = 'all .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);
