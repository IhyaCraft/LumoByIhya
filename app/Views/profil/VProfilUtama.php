
<?php
$nama = trim((string) ($nama ?? ''));
$email = (string) ($email ?? '');
$kelasSiswa = $kelasSiswa ?? null;
$namaDepan = $nama !== '' ? explode(' ', $nama)[0] : '';
$pelajaranSelesai = $pelajaranSelesai ?? null;
$pencapaian = $pencapaian ?? null;
$aktivitas = $aktivitas ?? null;
$aktivitasTerbaru = $aktivitasTerbaru ?? [];
$urlNotifikasi = $urlNotifikasi ?? null;
$adaNotifikasi = $adaNotifikasi ?? false;
$urlSemuaAktivitas = $urlSemuaAktivitas ?? null;

$adaGrafik = is_array($aktivitas)
    && count($aktivitas) === 7
    && array_sum(array_column($aktivitas, 'nilai')) > 0;

$totalAktivitas = $adaGrafik
    ? array_sum(array_column($aktivitas, 'nilai'))
    : null;

$hariAktif = $adaGrafik
    ? count(array_filter($aktivitas, static fn ($a) => ($a['nilai'] ?? 0) > 0))
    : null;

$ikon = [
    'book' => '<path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2z"/><path d="M9 7h6"/>',
    'bell' => '<path d="M6 8a6 6 0 0 1 12 0c0 7 3 8 3 8H3s3-1 3-8"/><path d="M10.3 21a1.9 1.9 0 0 0 3.4 0"/>',
    'check' => '<circle cx="12" cy="12" r="9"/><path d="M8 12l3 3 5-6"/>',
    'cal' => '<rect x="3" y="5" width="18" height="16" rx="3"/><path d="M8 3v4M16 3v4M3 10h18"/>',
    'trend' => '<path d="M3 17l6-6 4 4 8-8"/><path d="M15 7h6v6"/>',
    'star' => '<path d="M12 3l2.8 5.7 6.2.9-4.5 4.4 1 6.2-5.5-2.9-5.5 2.9 1-6.2L3 9.6l6.2-.9z"/>',
    'spark' => '<path d="M12 3l1.8 5.2L19 10l-5.2 1.8L12 17l-1.8-5.2L5 10l5.2-1.8z"/><path d="M19 16l.7 2 2 .7-2 .7-.7 2-.7-2-2-.7 2-.7z"/>',
    'pencil' => '<path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/>',
    'send' => '<path d="M22 2L11 13"/><path d="M22 2l-7 20-4-9-9-4z"/>',
    'chev' => '<path d="M9 6l6 6-6 6"/>',
    'out' => '<path d="M9 21H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/>',
];

$svg = static function (string $k) use ($ikon): string {
    return '<svg class="pu-ikon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">'
        . ($ikon[$k] ?? '')
        . '</svg>';
};

$stat = [
    ['ikon' => 'check', 'nilai' => $pelajaranSelesai, 'label' => 'Pelajaran selesai'],
    ['ikon' => 'star', 'nilai' => $pencapaian, 'label' => 'Pencapaian diraih'],
    ['ikon' => 'cal', 'nilai' => $hariAktif, 'label' => 'Hari aktif minggu ini'],
    ['ikon' => 'trend', 'nilai' => $totalAktivitas, 'label' => 'Aktivitas 7 hari'],
];

$labelStatus = [
    'selesai' => 'Selesai',
    'berjalan' => 'Berjalan',
    'baru' => 'Baru',
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>Profil | Lumo</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/profil/profil-utama.css') ?>">
</head>
<body class="profil-utama">

<div class="pu-shell">
    <main class="pu-main">
        
       
        <a class="pu-kembali" href="<?= site_url('beranda-sudah-login') ?>">

            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                aria-hidden="true">
                <path d="M19 12H5"/>
                <path d="m12 19-7-7 7-7"/>
            </svg>
            Kembali ke Beranda
        </a>

        <header class="pu-kepala">
            <div>
                <h1 class="pu-judul" data-sapaan data-nama="<?= esc($namaDepan, 'attr') ?>">
                    Halo<?= $namaDepan !== '' ? ', ' . esc($namaDepan) : '' ?>!
                </h1>
                <p class="pu-sub">Ini ringkasan perjalanan belajarmu</p>
            </div>

            <?php if ($urlNotifikasi): ?>
                <a class="pu-lonceng"
                   href="<?= esc($urlNotifikasi, 'attr') ?>"
                   aria-label="Notifikasi">
                    <?= $svg('bell') ?>
                    <?php if ($adaNotifikasi): ?>
                        <i class="pu-titik-notif"></i>
                    <?php endif; ?>
                </a>
            <?php endif; ?>
        </header>

        <section class="pu-hero" aria-label="Identitas pengguna">
            <div class="pu-hero-teks">
                <span class="pu-eyebrow">Profilku</span>

                <h2 class="pu-nama"><?= esc($namaDepan !== '' ? $namaDepan : $nama) ?></h2>

                <p class="pu-peran">
                    <?= $kelasSiswa ? esc($kelasSiswa) : esc($email) ?>
                </p>

                <p class="pu-status"><i></i>Online</p>

                <a class="pu-tombol" href="<?= site_url('profil/edit') ?>">
                    <?= $svg('pencil') ?>
                    Edit Profil
                </a>
            </div>

            <div class="pu-avatar">
                <?= view('partials/VMaskot', ['kelas' => 'pu-maskot', 'lengkap' => true]) ?>
            </div>
        </section>

        <section class="pu-stat-grid" aria-label="Ringkasan belajar">
            <?php foreach ($stat as $s): ?>
                <article class="pu-stat">
                    <span class="pu-stat-ikon">
                        <?= $svg($s['ikon']) ?>
                    </span>

                    <div>
                        <?php if ($s['nilai'] === null): ?>
                            <strong class="pu-angka">–</strong>
                        <?php else: ?>
                            <strong class="pu-angka" data-hitung="<?= (int) $s['nilai'] ?>">0</strong>
                        <?php endif; ?>

                        <span class="pu-stat-label"><?= esc($s['label']) ?></span>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>

        <section class="pu-kartu" aria-labelledby="pu-j-grafik">
            <div class="pu-kartu-kepala">
                <div>
                    <h2 id="pu-j-grafik" class="pu-kartu-judul">Aktivitas Belajar</h2>
                    <p class="pu-kartu-sub">7 hari terakhir</p>
                </div>

                <span class="pu-chip">
                    <?= $svg('cal') ?>
                    7 Hari
                </span>
            </div>

            <?php if ($adaGrafik): ?>
                <svg
                    class="pu-grafik"
                    id="pu-grafik"
                    role="img"
                    aria-label="Grafik aktivitas belajar 7 hari terakhir"
                    data-aktivitas="<?= esc(json_encode($aktivitas), 'attr') ?>">
                </svg>
            <?php else: ?>
                <div class="pu-kosong">
                    <svg viewBox="0 0 96 96" width="84" height="84" aria-hidden="true">
                        <rect x="14" y="52" width="14" height="30" rx="7" fill="#FCE3CF"/>
                        <rect x="41" y="34" width="14" height="48" rx="7" fill="#F6C79F"/>
                        <rect x="68" y="16" width="14" height="66" rx="7" fill="#C85F1B"/>
                    </svg>

                    <h3>Perjalanan belajarmu dimulai di sini!</h3>
                    <p>Yuk, selesaikan pelajaran pertamamu untuk melihat progresmu.</p>
                </div>
            <?php endif; ?>
        </section>

        <section class="pu-kartu pu-terbaru" aria-labelledby="pu-j-terbaru">
            <div class="pu-kartu-kepala">
                <h2 id="pu-j-terbaru" class="pu-kartu-judul">Aktivitas Terbaru</h2>

                <?php if (!empty($urlSemuaAktivitas)): ?>
                    <a class="pu-lihat" href="<?= esc($urlSemuaAktivitas, 'attr') ?>">
                        Lihat semua
                    </a>
                <?php endif; ?>
            </div>

            <?php if (empty($aktivitasTerbaru)): ?>
                <p class="pu-kosong-teks">
                    Belum ada aktivitas. Yuk, mulai pelajaran pertamamu!
                </p>
            <?php else: ?>
                <ul class="pu-daftar">
                    <?php foreach ($aktivitasTerbaru as $a): ?>
                        <?php
                        $st = $a['status'] ?? 'baru';
                        $statusValid = array_key_exists($st, $labelStatus) ? $st : 'baru';
                        $urlAktivitas = $a['url'] ?? null;
                        $tag = !empty($urlAktivitas) ? 'a' : 'div';
                        ?>

                        <li>
                            <<?= $tag ?>
                                class="pu-baris"
                                <?= $tag === 'a' ? 'href="' . esc($urlAktivitas, 'attr') . '"' : '' ?>>

                                <span class="pu-baris-ikon is-<?= esc($statusValid, 'attr') ?>">
                                    <?= $svg('book') ?>
                                </span>

                                <span class="pu-baris-teks">
                                    <strong><?= esc($a['judul'] ?? 'Aktivitas belajar') ?></strong>
                                    <small><?= esc($a['sub'] ?? '') ?></small>
                                </span>

                                <span class="pu-pil is-<?= esc($statusValid, 'attr') ?>">
                                    <?= esc($labelStatus[$statusValid]) ?>
                                </span>

                                <span class="pu-waktu"><?= esc($a['waktu'] ?? '') ?></span>

                                <?php if ($tag === 'a'): ?>
                                    <?= $svg('chev') ?>
                                <?php endif; ?>
                            </<?= $tag ?>>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </section>

        <form class="pu-keluar" method="post" action="<?= site_url('logout') ?>">
            <?= csrf_field() ?>
            <button type="submit">
                <?= $svg('out') ?>
                Keluar dari akun
            </button>
        </form>

        <a class="pu-aksi" href="<?= site_url('pelajaran') ?>">
            <?= $svg('spark') ?>
            <span>Mau lanjut belajar hari ini?</span>
            <span class="pu-kirim"><?= $svg('send') ?></span>
        </a>
    </main>
</div>

<script src="<?= base_url('assets/js/profil/profil-utama.js') ?>" defer></script>
</body>
</html>
