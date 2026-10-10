
const formKonfirmasiEmail = document.querySelector('#formKonfirmasiEmail');
const tombolKonfirmasiEmail = document.querySelector('#tombolKonfirmasiEmail');
const loadingDaftar = document.querySelector('#loadingDaftar');

if (formKonfirmasiEmail && tombolKonfirmasiEmail && loadingDaftar) {
    formKonfirmasiEmail.addEventListener('submit', function (event) {
        if (!formKonfirmasiEmail.checkValidity()) {
            event.preventDefault();
            formKonfirmasiEmail.reportValidity();
            return;
        }

        tombolKonfirmasiEmail.disabled = true;
        tombolKonfirmasiEmail.textContent = 'Memproses...';

        loadingDaftar.classList.add('aktif');
        loadingDaftar.setAttribute('aria-hidden', 'false');
    });
}
