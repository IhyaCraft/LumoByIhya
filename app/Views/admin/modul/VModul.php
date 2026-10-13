
<?php
$modul = $modul ?? [];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Modul Pembelajaran — Lumo') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/dashboard-admin.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/modul-admin.css') ?>">
</head>
<body>
    <main class="modul-admin">
        <header class="modul-admin-header">
            <div>
                <a href="<?= site_url('admin') ?>" class="modul-admin-back">
                    &larr; Kembali ke Dashboard
                </a>
                <h1>Modul Pembelajaran</h1>
                <p>Kelola modul yang akan dipelajari oleh anak-anak di Lumo.</p>
            </div>

            <a href="<?= site_url('admin/modul/tambah') ?>" class="modul-admin-add">
                <span aria-hidden="true">+</span>
                Tambah Modul
            </a>
        </header>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="modul-admin-alert modul-admin-alert-success" role="status">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="modul-admin-alert modul-admin-alert-error" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <section class="modul-admin-panel">
            <div class="modul-admin-panel-header">
                <div>
                    <h2>Daftar Modul</h2>
                    <p>Kelola judul, urutan, dan status modul pembelajaran.</p>
                </div>
                <span class="modul-admin-count">
                    <?= count($modul) ?> modul
                </span>
            </div>

            <?php if (empty($modul)): ?>
                <div class="modul-admin-empty">
                    <div class="modul-admin-empty-icon" aria-hidden="true">📚</div>
                    <h3>Belum ada modul pembelajaran</h3>
                    <p>Mulai tambahkan modul pertama untuk mengisi perpustakaan belajar Lumo.</p>
                    <a href="<?= site_url('admin/modul/tambah') ?>" class="modul-admin-add">
                        + Tambah Modul Pertama
                    </a>
                </div>
            <?php else: ?>
                <div class="modul-admin-table-wrap">
                    <table class="modul-admin-table">
                        <thead>
                            <tr>
                                <th scope="col">Modul</th>
                                <th scope="col">Urutan</th>
                                <th scope="col">Status</th>
                                <th scope="col">Dibuat</th>
                                <th scope="col">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($modul as $item): ?>
                                <tr>
                                    <td>
                                        <div class="modul-admin-identity">
                                            <?php if (!empty($item['gambar'])): ?>
                                                <img
                                                    src="<?= base_url($item['gambar']) ?>"
                                                    alt=""
                                                    class="modul-admin-thumbnail"
                                                    loading="lazy"
                                                >
                                            <?php else: ?>
                                                <div class="modul-admin-thumbnail modul-admin-thumbnail-empty" aria-hidden="true">
                                                    📘
                                                </div>
                                            <?php endif; ?>

                                            <div class="modul-admin-info">
                                                <span class="modul-admin-name">
                                                    <?= esc($item['judul']) ?>
                                                </span>
                                                <span class="modul-admin-description">
                                                    <?= esc($item['deskripsi'] ?: 'Belum ada deskripsi') ?>
                                                </span>
                                            </div>
                                        </div>
                                    </td>

                                    <td><?= esc((string) $item['urutan']) ?></td>

                                    <td>
                                        <span class="modul-admin-status <?= $item['status'] === 'aktif' ? 'is-active' : 'is-archived' ?>">
                                            <?= $item['status'] === 'aktif' ? 'Aktif' : 'Diarsipkan' ?>
                                        </span>
                                    </td>

                                    <td>
                                        <?= !empty($item['created_at']) ? esc(date('d M Y', strtotime($item['created_at']))) : '—' ?>
                                    </td>

                                    <td>
                                        <div class="modul-admin-actions">
                                            <a
                                                href="<?= site_url('admin/modul/edit/' . (int) $item['id']) ?>"
                                                class="modul-admin-action modul-admin-action-edit"
                                            >
                                                Edit
                                            </a>

                                            <?php if ($item['status'] === 'aktif'): ?>
                                                <form
                                                    action="<?= site_url('admin/modul/arsipkan/' . (int) $item['id']) ?>"
                                                    method="post"
                                                    onsubmit="return confirm('Arsipkan modul ini?')"
                                                >
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="modul-admin-action modul-admin-action-archive">
                                                        Arsipkan
                                                    </button>
                                                </form>
                                            <?php else: ?>
                                                <form
                                                    action="<?= site_url('admin/modul/pulihkan/' . (int) $item['id']) ?>"
                                                    method="post"
                                                    onsubmit="return confirm('Pulihkan modul ini?')"
                                                >
                                                    <?= csrf_field() ?>
                                                    <button type="submit" class="modul-admin-action modul-admin-action-restore">
                                                        Pulihkan
                                                    </button>
                                                </form>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </section>

        <footer class="modul-admin-footer">
            Lumo Education · Pengelolaan Modul Pembelajaran
        </footer>
    </main>
</body>
</html>
