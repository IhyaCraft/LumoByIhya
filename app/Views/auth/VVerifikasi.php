
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title><?= esc($judul ?? 'Verifikasi — Lumo') ?></title>
<link href="https://fonts.googleapis.com/css2?family=Nunito:wght@700;800;900&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('assets/css/home/home.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/auth/login.css') ?>">
<link rel="stylesheet" href="<?= base_url('assets/css/auth/verifikasi.css') ?>">
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
            <h2>Hampir selesai!</h2>
            <p>Cek email kamu dan masukkan kode verifikasi untuk mengaktifkan akun Lumo.</p>
        </div>
    </aside>

    <main class="area">
        <div class="kotak">
            <a class="kembali" href="<?= site_url('daftar') ?>">← Kembali ke daftar</a>

            <h1>Verifikasi email</h1>

            <p class="sub">
                Kami sudah mengirim kode verifikasi ke
                <strong><?= esc($email ?? '') ?></strong>
            </p>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="pesan error" role="alert">
                    <?= esc(session()->getFlashdata('error')) ?>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('success')): ?>
                <div class="pesan success" role="status">
                    <?= esc(session()->getFlashdata('success')) ?>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('verifikasi') ?>" method="post" id="formVerifikasi">
                <?= csrf_field() ?>

                <div class="bidang">
                    <label for="otp">Kode OTP</label>
                    <input
                        type="text"
                        id="otp"
                        name="otp"
                        inputmode="numeric"
                        maxlength="6"
                        autocomplete="one-time-code"
                        placeholder="Masukkan 6 digit kode"
                    >
                </div>

                <button type="submit" class="btn pri blok" id="tombolVerifikasi">
                  Verifikasi
              </button>

                <button
                type="button"
                class="btn-resend"
                id="tombolKirimUlang"
                disabled
                data-remaining="<?= esc($resendRemaining ?? 0) ?>"
                data-action="<?= site_url('kirim-ulang-otp') ?>"
              >
                <span>Kirim ulang OTP</span>
                <span id="hitungMundur"></span>
            </button>
            </form>

            <p class="hak">© <?= date('Y') ?> Lumo</p>
        </div>
    </main>

</div>

<script src="<?= base_url('assets/js/verifikasi.js') ?>"></script>
</body>
</html>