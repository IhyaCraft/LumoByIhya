
const sidebar = document.getElementById('sidebarAdmin');
const overlay = document.getElementById('overlayAdmin');
const toggle = document.getElementById('toggleSidebar');

function setSidebar(open) {
    sidebar?.classList.toggle('dashboard-admin-sidebar-open', open);
    overlay?.classList.toggle('dashboard-admin-overlay-visible', open);
    document.body.classList.toggle('dashboard-admin-menu-open', open);
    toggle?.setAttribute('aria-expanded', String(open));
}

toggle?.addEventListener('click', () => {
    const isOpen = sidebar?.classList.contains('dashboard-admin-sidebar-open');
    setSidebar(!isOpen);
});

overlay?.addEventListener('click', () => setSidebar(false));

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        setSidebar(false);
    }
});

const inputGambar = document.getElementById('gambar');
const namaFile = document.getElementById('fileName');
const areaUpload = document.getElementById('uploadArea');
const preview = document.getElementById('imagePreview');
const gambarPreview = document.getElementById('previewImage');
const tombolHapus = document.getElementById('removeImage');

let previewUrl = null;

function hapusGambar() {
    inputGambar.value = '';
    namaFile.textContent = 'Belum ada gambar dipilih';
    preview.hidden = true;
    gambarPreview.removeAttribute('src');

    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
        previewUrl = null;
    }
}

inputGambar?.addEventListener('change', () => {
    const file = inputGambar.files?.[0];

    if (!file) {
        hapusGambar();
        return;
    }

    const tipeDiizinkan = [
        'image/jpeg',
        'image/png',
        'image/webp'
    ];

    if (!tipeDiizinkan.includes(file.type)) {
        hapusGambar();
        alert('Format gambar harus JPG, PNG, atau WebP.');
        return;
    }

    if (file.size > 2 * 1024 * 1024) {
        hapusGambar();
        alert('Ukuran gambar maksimal 2 MB.');
        return;
    }

    if (previewUrl) {
        URL.revokeObjectURL(previewUrl);
    }

    previewUrl = URL.createObjectURL(file);
    gambarPreview.src = previewUrl;
    namaFile.textContent = file.name;
    preview.hidden = false;
});

tombolHapus?.addEventListener('click', hapusGambar);
