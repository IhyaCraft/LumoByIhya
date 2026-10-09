<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= esc($judul ?? 'Daftar — Lumo') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/home/home.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/auth/daftar.css') ?>">
</head>
<body>

<div class="login">

  <aside class="sisi">
    <a class="logo" href="<?= base_url('/') ?>"><i>💡</i>Lumo</a>

    <div class="panggung">
      <?= view('partials/VMaskot', ['kelas' => 'mk', 'lengkap' => true]) ?>
      <div class="fc f1">⭐ 320 Bintang</div>
      <div class="fc f2">🌱 Sains &amp; Alam</div>
      <div class="fc f3">🏆 5 Pencapaian</div>
    </div>

    <div class="sapa">
      <h2>Belajar. Jelajahi. Tumbuh.</h2>
      <p>Gabung yuk! Biar makin gampang nemenin dan mantau proses belajar si kecil.</p>
    </div>
  </aside>

  <main class="area">
    <div class="kotak">
      <a class="kembali" href="<?= base_url('/') ?>">← Kembali ke beranda</a>

      <h1>Selamat datang </h1>
      <p class="sub">Buat akun untuk mulai memantau dan mendampingi perkembangan belajar anak.</p>
        <?php if ($error = session()->getFlashdata('error')): ?>
    <div class="pesan-global error" role="alert">
        <?= esc($error) ?>
    </div>
<?php endif; ?>

<?php if ($errors = session()->getFlashdata('errors')): ?>
    <div class="pesan-global error" role="alert">
        <?= esc(implode(' ', $errors)) ?>
    </div>
<?php endif; ?>

      <form id="formDaftar" action="<?= site_url('daftar') ?>" method="post" novalidate>
    <?= csrf_field() ?>

    <div class="bidang">
        <label for="nama">Nama</label>
        <input
            type="text"
            id="nama"
            name="name"
            placeholder="Nama kamu"
            autocomplete="name"
            aria-describedby="err-nama"
        >
        <p class="err" id="err-nama" role="alert"></p>
    </div>

    <div class="bidang">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            name="email"
            placeholder="nama@email.com"
            autocomplete="email"
            inputmode="email"
            aria-describedby="err-email"
        >
        <p class="err" id="err-email" role="alert"></p>
    </div>

    <div class="bidang">
    <label for="sandi">Kata sandi</label>
    <div class="sandi">
        <input
            type="password"
            id="sandi"
            name="password"
            placeholder="Minimal 8 karakter"
            autocomplete="new-password"
            aria-describedby="err-password"
        >
        <button type="button" class="lihat" id="lihatSandi" aria-controls="sandi" aria-pressed="false">Lihat</button>
    </div>
    <p class="err" id="err-password" role="alert"></p>
</div>

    <button type="submit" class="btn pri blok" id="tombolDaftar">Daftar</button>
</form>
      <p class="hak">© <?= date('Y') ?> Lumo</p>
    </div>
  </main>

</div>
<div class="loading-daftar" id="loadingDaftar" aria-hidden="true">
    <div class="loading-card" role="status" aria-live="polite">
        <div class="loading-icon">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <h2>Kode verifikasi sedang dikirim...</h2>
        <p>Tunggu sebentar, ya!</p>
    </div>
</div>
<script src="<?= base_url('assets/js/daftar.js') ?>"></script>
</body>
</html>