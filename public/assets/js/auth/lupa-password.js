
const formKonfirmasiEmail = document.getElementById('formKonfirmasiEmail');
const loadingDaftar = document.getElementById('loadingDaftar');
const tombolKonfirmasiEmail = document.getElementById('tombolKonfirmasiEmail');

if (formKonfirmasiEmail && loadingDaftar) {
    formKonfirmasiEmail.addEventListener('submit', function (event) {
        if (!formKonfirmasiEmail.checkValidity()) {
            return;
        }

        loadingDaftar.classList.add('is-active');
        loadingDaftar.setAttribute('aria-hidden', 'false');

        if (tombolKonfirmasiEmail) {
            tombolKonfirmasiEmail.disabled = true;
        }
    });
}