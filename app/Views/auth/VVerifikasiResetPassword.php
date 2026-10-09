
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($judul ?? 'Verifikasi Reset Kata Sandi — Lumo') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/verifikasi-reset-password.css') ?>">
</head>
<body>

<main class="verifikasi-page">
    <section class="verifikasi-card">

        <header class="verifikasi-header">
            <div class="verifikasi-icon" aria-hidden="true">🔐</div>
            <h1>Verifikasi Reset Kata Sandi</h1>
            <p>Masukkan kode OTP yang kami kirim ke email kamu untuk melanjutkan reset kata sandi.</p>
            <p class="email-tujuan"><?= esc($email ?? '') ?></p>
        </header>

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

        <form action="<?= site_url('auth/verifikasi-reset-password') ?>" method="post">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="otp">Kode OTP</label>
                <input
                    type="text"
                    id="otp"
                    name="otp"
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    minlength="6"
                    maxlength="6"
                    autocomplete="one-time-code"
                    placeholder="Masukkan 6 digit kode"
                    aria-describedby="otp-hint"
                    required
                >
                <small id="otp-hint">Kode berlaku selama 5 menit.</small>
            </div>

            <button type="submit" class="btn-verifikasi">
                Verifikasi Kode
            </button>
        </form>

        <div class="kirim-ulang-wrapper">
            <p id="resend-info" aria-live="polite"></p>

            <form action="<?= site_url('auth/kirim-ulang-otp-reset') ?>" method="post" id="resend-form">
                <?= csrf_field() ?>

                <button
                    type="submit"
                    id="resend-button"
                    class="btn-kirim-ulang"
                    <?= (int) ($resendRemaining ?? 0) > 0 ? 'disabled' : '' ?>
                >
                    Kirim Ulang Kode
                </button>
            </form>
        </div>

        <a href="<?= site_url('auth/lupa-password') ?>" class="kembali">
            ← Kembali
        </a>

    </section>
</main>

<script>
(() => {
    const info = document.getElementById('resend-info');
    const button = document.getElementById('resend-button');
    let remaining = <?= max(0, (int) ($resendRemaining ?? 0)) ?>;
    let timer;

    function updateCountdown() {
        if (remaining > 0) {
            button.disabled = true;
            info.textContent = `Kirim ulang tersedia dalam ${remaining} detik.`;
            remaining--;
            timer = window.setTimeout(updateCountdown, 1000);
            return;
        }

        button.disabled = false;
        info.textContent = 'Belum menerima kode? Kamu bisa meminta kode baru.';
    }

    updateCountdown();
})();
</script>

</body>
</html>
