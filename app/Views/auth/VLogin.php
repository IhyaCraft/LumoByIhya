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

            <?php if (session()->getFlashdata('error')): ?>
                <div class="pesan error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <form id="formMasuk" action="<?= site_url('masuk') ?>" method="post" novalidate>
                <?= csrf_field() ?>

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
                    <label for="password">Kata sandi</label>

                    <div class="sandi">
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Minimal 8 karakter"
                            autocomplete="current-password"
                            aria-describedby="err-password"
                        >

                        <button
                            type="button"
                            class="lihat"
                            id="lihatSandi"
                            aria-controls="password"
                            aria-pressed="false"
                        >
                            Lihat
                        </button>
                    </div>

                    <p class="err" id="err-password" role="alert"></p>
                </div>


                <button
                    type="submit"
                    class="btn pri blok"
                    id="tombolMasuk"
                >
                    Masuk
                </button>

                

                <button
                    type="button"
                    class="btn sec blok"
                    id="tombolTamu"
                >
                    Masuk sebagai Tamu
                </button>

            </div>

            </form>
            
            <p class="pindah">
                Lupa kata sandi?
                <a href="<?= site_url('auth/lupa-password') ?>"> Reset</a>
            </p>

            <p class="pindah">
                Belum punya akun?
                <a href="<?= site_url('daftar') ?>">Buat akun</a>
            </p>

            <p class="hak">© <?= date('Y') ?> Lumo</p>

        </div>
    </main>

</div>

<script src="<?= base_url('assets/js/login.js') ?>"></script>
</body>
</html>