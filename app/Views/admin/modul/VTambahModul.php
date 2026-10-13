
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Tambah Modul — Lumo') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/dashboard-admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/tambah-modul.css') ?>">
</head>
<body>
<div class="dashboard-admin">
    <aside class="dashboard-admin-sidebar" id="sidebarAdmin">
        <a href="<?= site_url('admin') ?>" class="dashboard-admin-brand">
            <span class="dashboard-admin-brand-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M9 18h6M10 22h4M8 14a7 7 0 1 1 8 0c-1.2.9-1.5 2-1.5 3h-5c0-1-.3-2.1-1.5-3Z"/>
                </svg>
            </span>
            <span class="dashboard-admin-brand-text">
                <strong>Lumo</strong>
                <small>ADMIN PANEL</small>
            </span>
        </a>

        <div class="dashboard-admin-nav-label">MENU UTAMA</div>
        <nav class="dashboard-admin-nav">
            <a href="<?= site_url('admin') ?>" class="dashboard-admin-nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                    <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                    <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                </svg>
                Dashboard
            </a>
            <a href="<?= site_url('admin/modul') ?>" class="dashboard-admin-nav-item dashboard-admin-nav-item-active" aria-current="page">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21.5Z"/>
                    <path d="M4 5.5v16M8 7h8M8 11h8"/>
                </svg>
                Modul Pelajaran
            </a>
        </nav>

        <div class="dashboard-admin-sidebar-bottom">
            <div class="dashboard-admin-help-card">
                <div class="dashboard-admin-help-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M9.6 9a2.5 2.5 0 1 1 4.1 1.9c-1.1.8-1.7 1.2-1.7 2.6M12 17h.01"/>
                    </svg>
                </div>
                <strong>Kelola pembelajaran Lumo</strong>
                <p>Susun modul agar anak-anak bisa belajar dengan nyaman.</p>
            </div>
            <div class="dashboard-admin-profile">
                <div class="dashboard-admin-avatar">
                    <?= esc(strtoupper(substr((string) session('name'), 0, 1) ?: 'A')) ?>
                </div>
                <div class="dashboard-admin-profile-info">
                    <strong><?= esc(session('name') ?: 'Administrator') ?></strong>
                    <span>Administrator</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="dashboard-admin-overlay" id="overlayAdmin"></div>

    <main class="dashboard-admin-main">
        <header class="dashboard-admin-header">
            <button type="button" class="dashboard-admin-menu-toggle" id="toggleSidebar" aria-label="Buka menu" aria-expanded="false">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="dashboard-admin-breadcrumb">
                <a href="<?= site_url('admin') ?>">Dashboard</a>
                <span>/</span>
                <a href="<?= site_url('admin/modul') ?>">Modul Pelajaran</a>
                <span>/</span>
                <strong>Tambah Modul</strong>
            </div>

            <div class="dashboard-admin-header-right">
                <div class="dashboard-admin-status">
                    <span></span>
                    Panel Admin
                </div>
                <div class="dashboard-admin-header-avatar">
                    <?= esc(strtoupper(substr((string) session('name'), 0, 1) ?: 'A')) ?>
                </div>
            </div>
        </header>

        <div class="dashboard-admin-content">
            <section class="dashboard-admin-section tambah-modul-heading">
                <a href="<?= site_url('admin/modul') ?>" class="tambah-modul-back">
                    <span aria-hidden="true">←</span>
                    Kembali ke daftar modul
                </a>

                <div class="dashboard-admin-eyebrow">MANAJEMEN PEMBELAJARAN</div>
                <h1>Tambah Modul Pelajaran</h1>
                <p>Buat modul baru untuk membantu anak-anak belajar bersama Lumo.</p>
            </section>

            <?php $errors = session()->getFlashdata('errors') ?? []; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="tambah-modul-alert" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <section class="tambah-modul-card">
                <div class="tambah-modul-card-heading">
                    <div>
                        <h2>Informasi Modul</h2>
                        <p>Lengkapi informasi dasar modul yang akan ditampilkan.</p>
                    </div>
                    <span class="tambah-modul-required"><span>*</span> Wajib diisi</span>
                </div>

                <form action="<?= site_url('admin/modul/tambah') ?>" method="post" enctype="multipart/form-data" class="tambah-modul-form">
                    <?= csrf_field() ?>

                    <div class="tambah-modul-field">
                        <label for="judul">Judul Modul <span>*</span></label>
                        <input
                            type="text"
                            id="judul"
                            name="judul"
                            value="<?= esc(old('judul')) ?>"
                            maxlength="150"
                            placeholder="Contoh: Mengenal Hewan"
                            required
                            autocomplete="off"
                            aria-describedby="judulError"
                        >
                        <?php if (isset($errors['judul'])): ?>
                            <small class="tambah-modul-error" id="judulError"><?= esc($errors['judul']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="tambah-modul-field">
                        <label for="deskripsi">Deskripsi Modul <span class="tambah-modul-optional">Opsional</span></label>
                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="4"
                            placeholder="Ceritakan secara singkat materi yang akan dipelajari anak."
                        ><?= esc(old('deskripsi')) ?></textarea>
                        <?php if (isset($errors['deskripsi'])): ?>
                            <small class="tambah-modul-error"><?= esc($errors['deskripsi']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="tambah-modul-field">
                        <label for="gambar">Gambar Modul <span class="tambah-modul-optional">Opsional</span></label>
                        <label for="gambar" class="tambah-modul-upload" id="uploadArea">
                            <input type="file" id="gambar" name="gambar" accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                            <span class="tambah-modul-upload-icon" aria-hidden="true">↑</span>
                            <strong>Pilih gambar modul</strong>
                            <span>JPG, PNG, atau WebP · Maksimal 2 MB</span>
                            <span class="tambah-modul-file-name" id="fileName">Belum ada gambar dipilih</span>
                        </label>
                        <?php if (isset($errors['gambar'])): ?>
                            <small class="tambah-modul-error"><?= esc($errors['gambar']) ?></small>
                        <?php endif; ?>
                        <div class="tambah-modul-preview" id="imagePreview" hidden>
                            <img id="previewImage" src="" alt="Pratinjau gambar modul">
                            <button type="button" id="removeImage" class="tambah-modul-remove">Hapus gambar</button>
                        </div>
                    </div>

                    <div class="tambah-modul-field tambah-modul-order">
                        <label for="urutan">Urutan Modul</label>
                        <input
                            type="number"
                            id="urutan"
                            name="urutan"
                            value="<?= esc(old('urutan', '0')) ?>"
                            min="0"
                            step="1"
                            required
                        >
                        <small>Angka lebih kecil akan ditampilkan lebih awal.</small>
                        <?php if (isset($errors['urutan'])): ?>
                            <small class="tambah-modul-error"><?= esc($errors['urutan']) ?></small>
                        <?php endif; ?>
                    </div>

                    <div class="tambah-modul-actions">
                        <a href="<?= site_url('admin/modul') ?>" class="tambah-modul-btn tambah-modul-btn-secondary">Batal</a>
                        <button type="submit" class="tambah-modul-btn tambah-modul-btn-primary">
                            Simpan Modul
                            <span aria-hidden="true">→</span>
                        </button>
                    </div>
                </form>
            </section>

            <footer class="dashboard-admin-footer">
                <span>© <?= date('Y') ?> Lumo Education</span>
                <span>Belajar jadi lebih menyenangkan.</span>
            </footer>
        </div>
    </main>
</div>

<script src="<?= base_url('assets/js/admin/tambah-modul.js') ?>" defer></script>
</body>
</html>
