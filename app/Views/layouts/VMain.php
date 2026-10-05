<?php

$menu = [
    ['Beranda',      '#beranda'],
    ['Pelajaran',    '#pelajaran'],
    ['Cara Kerja',   '#cara-kerja'],
    ['Tentang Kami', '#tentang'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= esc($judul ?? 'Lumo') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
</head>
<body>

<nav><div class="wrap nv">
  <a class="logo" href="#beranda"><i>💡</i>Lumo</a>
  <div class="links">
    <?php foreach ($menu as [$teks, $link]): ?>
      <a href="<?= $link ?>"><?= $teks ?></a>
    <?php endforeach; ?>
  </div>
  <div class="rt">
    <a class="btn sec" href="<?=site_url('masuk')?>">Masuk</a>
    <a class="btn pri" href="<?=site_url('daftar')?>">Mulai Sekarang</a>
    <button class="mb" id="mb" aria-label="Buka menu" aria-expanded="false">☰</button>
  </div>
</div>
<div class="mm" id="mm">
  <?php foreach ($menu as [$teks, $link]): ?>
    <a href="<?= $link ?>"><?= $teks ?></a>
  <?php endforeach; ?>
  <a href="#">Masuk</a>
  <a class="btn pri" href="#daftar">Mulai Sekarang</a>
</div>
</nav>

<main>
  <?= $this->renderSection('konten') ?>
</main>

<footer><div class="wrap">
  <div class="fg">
    <div>
      <div class="logo"><i>💡</i>Lumo</div>
      <p style="color:var(--mu);margin-top:8px">Belajar. Jelajahi. Tumbuh.</p>
    </div>
    <div>
      <h4>Navigasi</h4>
      <?php foreach ($menu as [$teks, $link]): ?>
        <a href="<?= $link ?>"><?= $teks ?></a>
      <?php endforeach; ?>
    </div>
    <div>
      <h4>Untuk Orang Tua</h4>
      <a href="<?= site_url('masuk') ?>">Masuk</a>
      <a href="#">Buat Akun</a>
    </div>
    <div>
      <h4>Informasi</h4>
      <a href="#">Privasi</a>
      <a href="#">Ketentuan</a>
    </div>
  </div>
  <p class="cp">© <?= date('Y') ?> Lumo</p>
</div></footer>

<script src="<?= base_url('assets/js/home.js') ?>"></script>
</body>
</html>