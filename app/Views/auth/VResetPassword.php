
<?php
$session = session();

$flashError = $session->getFlashdata('error');
$flashSuccess = $session->getFlashdata('success');
$flashErrors = $session->getFlashdata('errors');

if (is_string($flashErrors) && $flashErrors !== '') {
    $flashErrors = [$flashErrors];
} elseif (! is_array($flashErrors)) {
    $flashErrors = [];
}

$normalizeMessage = static function ($message): string {
    if (is_array($message)) {
        return implode(' ', array_map(
            static fn ($item) => is_scalar($item) ? (string) $item : '',
            $message
        ));
    }

    return is_scalar($message) ? (string) $message : '';
};
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="color-scheme" content="light">
    <title><?= esc($judul ?? 'Reset Kata Sandi — Lumo') ?></title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= esc(base_url('assets/css/auth/reset-password.css'), 'attr') ?>">
</head>
<body class="lrp-page">
    <main class="lrp-wrap">
        <section class="lrp-card" aria-labelledby="lrp-title">
            <a class="lrp-brand" href="<?= esc(site_url('/'), 'attr') ?>" aria-label="Lumo, kembali ke beranda">
                <span class="lrp-brand__dot" aria-hidden="true"></span>
                <span class="lrp-brand__text">Lumo</span>
            </a>

            <header class="lrp-header">
                <h1 class="lrp-title" id="lrp-title">Buat kata sandi baru</h1>
                <p class="lrp-desc">
                    Sedikit lagi selesai! Buat kata sandi baru supaya kamu bisa kembali belajar dan bermain bersama Lumo.
                </p>
            </header>

            <?php if ($flashSuccess !== null && $normalizeMessage($flashSuccess) !== '') : ?>
                <div class="lrp-alert lrp-alert--success" role="status">
                    <?= esc($normalizeMessage($flashSuccess)) ?>
                </div>
            <?php endif; ?>

            <?php if ($flashError !== null && $normalizeMessage($flashError) !== '') : ?>
                <div class="lrp-alert lrp-alert--error" role="alert">
                    <?= esc($normalizeMessage($flashError)) ?>
                </div>
            <?php endif; ?>

            <?php if ($flashErrors !== []) : ?>
                <div class="lrp-alert lrp-alert--error" role="alert">
                    <ul class="lrp-alert__list">
                        <?php foreach ($flashErrors as $item) : ?>
                            <?php if (is_scalar($item) && (string) $item !== '') : ?>
                                <li><?= esc((string) $item) ?></li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form
                class="lrp-form"
                method="post"
                action="<?= esc(site_url('auth/reset-password'), 'attr') ?>"
                data-lrp="form"
            >
                <?= csrf_field() ?>

                <div class="lrp-field">
                    <label class="lrp-label" for="lrp-password">
                        Kata sandi baru
                    </label>

                    <input
                        class="lrp-input"
                        type="password"
                        id="lrp-password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        autocomplete="new-password"
                        minlength="8"
                        maxlength="255"
                        required
                        data-lrp="password"
                        aria-describedby="lrp-password-error lrp-rules"
                    >

                    <p
                        class="lrp-field__error"
                        id="lrp-password-error"
                        data-lrp="password-error"
                        aria-live="polite"
                    ></p>
                </div>

                <div class="lrp-field">
                    <label class="lrp-label" for="lrp-confirm">
                        Ulangi kata sandi baru
                    </label>

                    <input
                        class="lrp-input"
                        type="password"
                        id="lrp-confirm"
                        name="konfirmasi_password"
                        placeholder="Ketik ulang kata sandimu"
                        autocomplete="new-password"
                        minlength="8"
                        maxlength="255"
                        required
                        data-lrp="confirm"
                        aria-describedby="lrp-confirm-error lrp-rules"
                    >

                    <p
                        class="lrp-field__error"
                        id="lrp-confirm-error"
                        data-lrp="confirm-error"
                        aria-live="polite"
                    ></p>
                </div>

                <button
                    class="lrp-toggle"
                    type="button"
                    data-lrp="toggle"
                    aria-pressed="false"
                    aria-controls="lrp-password lrp-confirm"
                >
                    <svg
                        class="lrp-toggle__icon lrp-toggle__icon--show"
                        viewBox="0 0 24 24"
                        width="18"
                        height="18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/>
                        <circle cx="12" cy="12" r="3"/>
                    </svg>

                    <svg
                        class="lrp-toggle__icon lrp-toggle__icon--hide"
                        viewBox="0 0 24 24"
                        width="18"
                        height="18"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="2"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 19c-6.5 0-10-7-10-7a18.5 18.5 0 0 1 5.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 5c6.5 0 10 7 10 7a18.5 18.5 0 0 1-2.16 3.19"/>
                        <path d="M14.12 14.12a3 3 0 1 1-4.24-4.24"/>
                        <line x1="2" y1="2" x2="22" y2="22"/>
                    </svg>

                    <span data-lrp="toggle-text">Tampilkan kata sandi</span>
                </button>

                <ul class="lrp-rules" id="lrp-rules" aria-label="Syarat kata sandi">
                    <li class="lrp-rule" data-lrp-rule="length">
                        <span class="lrp-rule__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <span class="lrp-rule__text">Minimal 8 karakter</span>
                        <span class="lrp-sr" data-lrp-rule-status>Belum terpenuhi</span>
                    </li>

                    <li class="lrp-rule" data-lrp-rule="match">
                        <span class="lrp-rule__icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="12" height="12" fill="none" stroke="currentColor" stroke-width="3.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="20 6 9 17 4 12"/>
                            </svg>
                        </span>
                        <span class="lrp-rule__text">Kedua kata sandi sama</span>
                        <span class="lrp-sr" data-lrp-rule-status>Belum terpenuhi</span>
                    </li>
                </ul>

                <button class="lrp-submit" type="submit" data-lrp="submit">
                    <span class="lrp-submit__label">Simpan Kata Sandi</span>
                    <span class="lrp-submit__spinner" aria-hidden="true"></span>
                </button>
            </form>
        </section>
    </main>

    <script src="<?= esc(base_url('assets/js/auth/reset-password.js'), 'attr') ?>" defer></script>
</body>
</html>