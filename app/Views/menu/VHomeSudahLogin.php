<?php
$menu = [
    ['Home',       '🏠', base_url('home'), true],
    ['Pelajaran',  '📚', '#',              false],
    ['Pencapaian', '🏆', '#',              false],
    ['Profil',     '👤', '#',              false],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= esc($judul ?? 'Beranda — Lumo') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/HomeSudahLogin.css') ?>">
</head>
<body>

<div class="hm" data-nama="<?= esc($namaDepan, 'attr') ?>">

  <nav class="hm-nav" aria-label="Menu utama">
    <a class="logo hm-logo" href="<?= base_url('home') ?>"><i>💡</i>Lumo</a>
    <?php foreach ($menu as [$label, $ikon, $url, $aktif]): ?>
      <a href="<?= $url ?>" <?= $aktif ? 'class="aktif" aria-current="page"' : '' ?>>
        <span class="ik" aria-hidden="true"><?= $ikon ?></span>
        <span><?= esc($label) ?></span>
      </a>
    <?php endforeach; ?>
  </nav>

  <main class="hm-main">

    <header class="hm-sapa hm-in" style="--i:0">
      <span class="hm-deko d1" aria-hidden="true"></span>
      <span class="hm-deko d2" aria-hidden="true"></span>
      <div class="hm-teks">
        <span class="hm-waktu" id="waktu"></span>
        <h1>Hai, <?= esc($namaDepan) ?>! <span class="hm-wave" aria-hidden="true">👋</span></h1>
        <p>Yuk lanjut belajar hari ini.</p>
      </div>
      <div class="hm-maskot">
        <?= view('partials/VMaskot', ['kelas' => 'hm-mk', 'lengkap' => true]) ?>
        <div class="hm-gel" id="gel" role="status"></div>
      </div>
    </header>

    <section class="hm-lanjut hm-in <?= esc($lanjut['warna']) ?>" style="--i:1" aria-labelledby="t-lanjut">
      <p class="hm-pil">Yuk, lanjut belajar!</p>
      <div class="hm-isi">
        <div class="ic"><?= $lanjut['ikon'] ?></div>
        <div>
          <p class="hm-mapel"><?= esc($lanjut['mapel']) ?></p>
          <h2 id="t-lanjut"><?= esc($lanjut['materi']) ?></h2>
        </div>
      </div>
      <div class="hm-bar" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="<?= (int) $lanjut['progres'] ?>" aria-label="Progress <?= esc($lanjut['materi']) ?>">
        <i data-nilai="<?= (int) $lanjut['progres'] ?>"></i>
      </div>
      <div class="hm-baris">
        <span class="hm-persen">Progress <span id="angkaPersen"><?= (int) $lanjut['progres'] ?></span>%</span>
        <a class="btn pri" href="<?= esc($lanjut['tautan']) ?>">Lanjutkan</a>
      </div>
    </section>

    <section aria-labelledby="t-pelajaran">
      <h2 class="hm-judul" id="t-pelajaran" data-rv>Pelajaran</h2>
      <div class="hm-grid">
        <?php foreach ($pelajaran as [$warna, $ikon, $nama, $jumlah, $url]): ?>
          <a class="card hm-kartu" href="<?= esc($url) ?>" data-rv data-tilt>
            <div class="ic <?= $warna ?>"><?= $ikon ?></div>
            <h3><?= esc($nama) ?></h3>
            <p><?= esc($jumlah) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </section>

    <section aria-labelledby="t-progres">
      <h2 class="hm-judul" id="t-progres" data-rv>Progress Belajarmu</h2>
      <div class="hm-stat">
        <?php foreach ($statistik as [$ikon, $angka, $label]): ?>
          <div class="card" data-rv data-tilt>
            <span class="hm-emo" aria-hidden="true"><?= $ikon ?></span>
            <b data-hitung><?= esc((string) $angka) ?></b>
            <span><?= esc($label) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

  </main>
</div>

<script src="<?= base_url('assets/js/home.js') ?>"></script>
</body>
</html>