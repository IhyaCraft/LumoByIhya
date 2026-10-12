<?php

$nama = trim((string) session()->get('nama'));
$nama = $nama !== '' ? explode(' ', $nama)[0] : 'Teman';

$pelajaran = $pelajaran ?? [
    [
        'slug' => 'mengenal-bilangan',
        'nomor' => '01',
        'ikon' => '🔢',
        'warna' => 'bilangan',
        'nama' => 'Mengenal Bilangan',
        'deskripsi' => 'Kenali angka, nilai tempat, dan cara membandingkan bilangan.',
        'url' => site_url('pelajaran/matematika/mengenal-bilangan'),
    ],
    [
        'slug' => 'penjumlahan-pengurangan',
        'nomor' => '02',
        'ikon' => '🧮',
        'warna' => 'operasi',
        'nama' => 'Penjumlahan & Pengurangan',
        'deskripsi' => 'Belajar menghitung dengan cara yang mudah dan menyenangkan.',
        'url' => site_url('pelajaran/matematika/penjumlahan-pengurangan'),
    ],
    [
        'slug' => 'perkalian-pembagian',
        'nomor' => '03',
        'ikon' => '✖️',
        'warna' => 'perkalian',
        'nama' => 'Perkalian & Pembagian',
        'deskripsi' => 'Pahami perkalian dan pembagian melalui contoh sederhana.',
        'url' => site_url('pelajaran/matematika/perkalian-pembagian'),
    ],
    [
        'slug' => 'soal-cerita',
        'nomor' => '04',
        'ikon' => '🧩',
        'warna' => 'cerita',
        'nama' => 'Soal Cerita',
        'deskripsi' => 'Gunakan kemampuan berhitung untuk memecahkan masalah sehari-hari.',
        'url' => site_url('pelajaran/matematika/soal-cerita'),
    ],
];

$progres = $progres ?? [];

$totalSelesai = 0;

foreach ($pelajaran as $item) {
    if (($progres[$item['slug']]['selesai'] ?? false) === true) {
        $totalSelesai++;
    }
}

$persen = (int) round(($totalSelesai / count($pelajaran)) * 100);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#F8F6F0">

    <title>Matematika — Lumo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/pelajaran/modul-matematika.css') ?>">
</head>

<body>
    <header class="math-header">
        <div class="math-header-inner">
            <a class="math-logo" href="<?= site_url('/') ?>" aria-label="Kembali ke beranda Lumo">
                <span class="math-logo-icon">💡</span>
                <span>Lumo</span>
            </a>

            <div class="math-header-actions">
                <span class="math-user">
                    <span class="math-user-icon">👋</span>
                    Hai, <?= esc($nama) ?>!
                </span>

                <a class="math-back" href="<?= site_url('/') ?>">
                    <span aria-hidden="true">←</span>
                    Beranda
                </a>
            </div>
        </div>
    </header>

    <main class="math-main">
        <section class="math-hero">
            <div class="math-hero-content">
                <span class="math-eyebrow">
                    <span aria-hidden="true">✨</span>
                    PETUALANGAN BELAJAR
                </span>

                <h1>Matematika jadi <span>seru!</span></h1>

                <p>
                    Yuk, asah kemampuan berhitungmu. Pilih pelajaran,
                    pelajari materinya, lalu kumpulkan bintang!
                </p>

                <a class="math-primary-btn" href="#daftar-pelajaran">
                    Mulai belajar
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="math-hero-art" aria-hidden="true">
                <span class="math-float math-float-one">＋</span>
                <span class="math-float math-float-two">÷</span>
                <span class="math-float math-float-three">×</span>

                <div class="math-illustration">
                    <span class="math-big-number">123</span>
                    <span class="math-equation">2 + 3 = 5</span>
                    <span class="math-sparkle">✦</span>
                </div>
            </div>
        </section>

        <section class="math-progress" aria-labelledby="progress-title">
            <div class="math-progress-top">
                <div>
                    <span class="math-section-label">PERJALANANMU</span>
                    <h2 id="progress-title">Terus bertumbuh! 🌱</h2>
                    <p id="progress-description">
                        Kamu sudah menyelesaikan <?= $totalSelesai ?> dari
                        <?= count($pelajaran) ?> pelajaran.
                    </p>
                </div>

                <div class="math-progress-number">
                    <strong><?= $persen ?>%</strong>
                    <span>terselesaikan</span>
                </div>
            </div>

            <div
                class="math-progress-track"
                id="progressTrack"
                role="progressbar"
                aria-label="Progres belajar Matematika"
                aria-valuemin="0"
                aria-valuemax="100"
                aria-valuenow="<?= $persen ?>"
            >
                <div class="math-progress-fill" style="width: <?= $persen ?>%"></div>
            </div>
        </section>

        <section class="math-lessons" id="daftar-pelajaran">
            <div class="math-section-heading">
                <div>
                    <span class="math-section-label">PILIH PETUALANGANMU</span>
                    <h2>Yuk, pilih pelajaran!</h2>
                    <p>Empat langkah kecil menuju jago Matematika.</p>
                </div>

                <span class="math-count"><?= count($pelajaran) ?> pelajaran</span>
            </div>

            <div class="math-card-grid">
                <?php foreach ($pelajaran as $item): ?>
                    <?php
                    $itemSelesai = ($progres[$item['slug']]['selesai'] ?? false) === true;
                    $itemPersen = $itemSelesai
                        ? 100
                        : max(0, min(99, (int) ($progres[$item['slug']]['persen'] ?? 0)));
                    ?>

                    <a
                        class="math-card <?= esc($item['warna'], 'attr') ?>"
                        href="<?= esc($item['url'], 'attr') ?>"
                    >
                        <div class="math-card-top">
                            <span class="math-card-number">
                                <?= esc($item['nomor']) ?>
                            </span>

                            <?php if ($itemSelesai): ?>
                                <span class="math-completed" aria-label="Pelajaran selesai">
                                    ✓ Selesai
                                </span>
                            <?php else: ?>
                                <span class="math-card-arrow" aria-hidden="true">↗</span>
                            <?php endif; ?>
                        </div>

                        <div class="math-card-icon" aria-hidden="true">
                            <?= esc($item['ikon']) ?>
                        </div>

                        <h3><?= esc($item['nama']) ?></h3>

                        <p><?= esc($item['deskripsi']) ?></p>

                        <div class="math-card-bottom">
                            <div class="math-mini-track">
                                <div style="width: <?= $itemPersen ?>%"></div>
                            </div>

                            <span class="math-card-percent">
                                <?= $itemPersen ?>%
                            </span>
                        </div>

                        <span class="math-card-cta">
                            <?= $itemSelesai ? 'Pelajari lagi' : 'Ayo belajar' ?>
                            <span aria-hidden="true">→</span>
                        </span>
                    </a>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="math-motivation">
            <div class="math-motivation-icon" aria-hidden="true">🌟</div>

            <div>
                <h2>Satu soal, satu langkah lebih pintar!</h2>
                <p>Nggak harus langsung bisa. Terus mencoba itu yang hebat!</p>
            </div>
        </section>

        <?= $this->include('partials/VMaskot') ?>
    </main>

    <footer class="math-footer">
        <span>💡 Lumo</span>
        <p>Belajar. Jelajahi. Tumbuh.</p>
    </footer>

    <script src="<?= base_url('assets/js/pelajaran/modul-matematika.js') ?>" defer></script>
</body>
</html>