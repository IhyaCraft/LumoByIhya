<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Kata Sandi — Lumo</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/auth/lupa-password.css') ?>">
</head>

<body>

<main class="lupa-page">
    <div class="lupa-card">

        <div class="lupa-header">
            <div class="lupa-icon">🔐</div>

            <h1>Lupa Kata Sandi?</h1>

            <p>
                Masukkan email yang terdaftar di Lumo untuk mendapatkan kode verifikasi.
            </p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="pesan error">
                <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="pesan success">
                <?= esc(session()->getFlashdata('success')) ?>
            </div>
        <?php endif; ?>

        <form action="<?= site_url('auth/lupa-password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">Email</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="<?= esc(old('email')) ?>"
                    placeholder="Masukkan email kamu"
                    autocomplete="email"
                    required
                >
            </div>

            <button type="submit" class="btn-verifikasi">
                Kirim Kode Verifikasi
            </button>
        </form>

        <a href="<?= site_url('masuk') ?>" class="kembali">
            ← Kembali ke Masuk
        </a>

    </div>
</main>

</body>
</html>
