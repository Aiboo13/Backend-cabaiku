/**
 * Tips & Artikel Page JS — resources/js/pages/tips.js
 */

/** Show/hide the clear button based on input value */
function toggleClear(input) {
    document.getElementById('clear-btn').classList.toggle('show', input.value.length > 0);
}

/** Clear search and re-submit the filter form */
function clearSearch() {
    document.getElementById('search-inp').value = '';
    document.getElementById('clear-btn').classList.remove('show');
    document.getElementById('filter-form').submit();
}

// Auto-submit search after 600 ms of inactivity
let searchTimer;
document.getElementById('search-inp')?.addEventListener('input', function () {
    clearTimeout(searchTimer);
    searchTimer = setTimeout(() => document.getElementById('filter-form').submit(), 600);
});
