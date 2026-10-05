<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= esc($judul ?? 'Masuk — Lumo') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/home.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/login.css') ?>">
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
      <p>Masuk dan lihat sudah sejauh mana petualangan belajar anakmu.</p>
    </div>
  </aside>

  <main class="area">
    <div class="kotak">
      <a class="kembali" href="<?= base_url('/') ?>">← Kembali ke beranda</a>

      <h1>Selamat datang kembali!</h1>
      <p class="sub">Masuk untuk melihat perkembangan belajar anak.</p>

      <form id="formMasuk" novalidate>
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
              name="sandi"
              placeholder="Minimal 8 karakter"
              autocomplete="current-password"
              aria-describedby="err-sandi"
            >
            <button type="button" class="lihat" id="lihatSandi" aria-controls="sandi" aria-pressed="false">Lihat</button>
          </div>
          <p class="err" id="err-sandi" role="alert"></p>
        </div>

        <div class="baris">
          <label class="centang">
            <input type="checkbox" name="ingat" value="1">
            <span>Ingat saya</span>
          </label>
          <a class="lupa" href="#">Lupa kata sandi?</a>
        </div>

        <button type="submit" class="btn pri blok" id="tombolMasuk">Masuk
        <button type="submit" class="btn sec blok" id="tombolTamu">Masuk sebagai Tamu</button>
      </form>

      <p class="pindah">Belum punya akun? <a href="<?=site_url('daftar')?>">Buat akun</a></p>
      <p class="hak">© <?= date('Y') ?> Lumo</p>
    </div>
  </main>

</div>

<script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>
</html>