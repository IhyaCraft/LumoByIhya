
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">

    <title><?= esc($judul ?? 'Konfirmasi Email — Lumo') ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/home/home.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth/login.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth/verifikasi.css') ?>">
</head>
<body>

<div class="login">

    <aside class="sisi">
        <a class="logo" href="<?= site_url('/') ?>">
            <i>💡</i>Lumo
        </a>

        <div class="panggung">
            <?= view('partials/VMaskot', ['kelas' => 'mk', 'lengkap' => true]) ?>

            <div class="fc f1">⭐ 320 Bintang</div>
            <div class="fc f2">🌱 Sains &amp; Alam</div>
            <div class="fc f3">🏆 5 Pencapaian</div>
        </div>

        <div class="sapa">
            <h2>Tenang, yuk!</h2>
            <p>Masukkan email akun kamu untuk memulai pemulihan kata sandi.</p>
        </div>
    </aside>

    <main class="area">
        <div class="kotak">

            <a class="kembali" href="<?= site_url('masuk') ?>">
                ← Kembali ke masuk
            </a>

            <h1>Konfirmasi email</h1>

            <p class="sub">
                Masukkan alamat email yang terdaftar di akun Lumo untuk melanjutkan pemulihan kata sandi.
            </p>

            <?php if ($error = session()->getFlashdata('error')): ?>
                <div class="pesan error" role="alert">
                    <?= esc($error) ?>
                </div>
            <?php endif; ?>

            <?php if ($success = session()->getFlashdata('success')): ?>
                <div class="pesan success" role="status">
                    <?= esc($success) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('auth/lupa-password') ?>" method="post" id="formKonfirmasiEmail">
                <?= csrf_field() ?>

                <div class="bidang">
                    <label for="email">Alamat email</label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="nama@email.com"
                        autocomplete="email"
                        value="<?= esc(old('email') ?? '') ?>"
                        required
                    >
                </div>

                <button type="submit" class="btn pri blok">
                    Lanjutkan
                </button>
            </form>

            <p class="hak">© <?= date('Y') ?> Lumo</p>

        </div>
    </main>

</div>

</body>
</html>