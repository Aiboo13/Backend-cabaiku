/**
 * Landing Page JS — resources/js/landing.js
 */

/** Toggle mobile menu */
function toggleMenu() {
    const menu = document.getElementById('mobileMenu');
    menu.classList.toggle('active');
}

// Close mobile menu when a link inside it is clicked
document.querySelectorAll('.mobile-menu a').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('mobileMenu').classList.remove('active');
    });
});

// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({ behavior: 'smooth' });
        }
    });
});

// Auth navigation (prevents double-navigation issues)
document.querySelectorAll('.js-auth-nav').forEach(a => {
    a.addEventListener('click', function (e) {
        e.preventDefault();
        window.location.assign(this.dataset.target || this.getAttribute('href'));
    });
});
