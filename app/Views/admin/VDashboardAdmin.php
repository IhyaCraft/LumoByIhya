
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#F8F6F0">
    <title><?= esc($title ?? 'Dashboard Admin — Lumo') ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/admin/dashboard-admin.css') ?>">
</head>
<body>
    <div class="dashboard-admin">
        <div class="dashboard-admin-overlay" id="dashboardAdminOverlay"></div>

        <aside class="dashboard-admin-sidebar" id="dashboardAdminSidebar">
            <a href="<?= site_url('admin') ?>" class="dashboard-admin-brand">
                <span class="dashboard-admin-brand-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 18h6M10 21h4M8.5 14.5a7 7 0 1 1 7 0c-.8.6-1.2 1.4-1.2 2.5h-4.6c0-1.1-.4-1.9-1.2-2.5Z"/>
                        <path d="M12 3v2M5.6 5.6 7 7M18.4 5.6 17 7"/>
                    </svg>
                </span>
                <span class="dashboard-admin-brand-text">
                    <strong>Lumo</strong>
                    <small>EDUCATION</small>
                </span>
            </a>

            <div class="dashboard-admin-nav-label">MENU UTAMA</div>

            <nav class="dashboard-admin-nav">
                <a href="#ringkasan" class="dashboard-admin-nav-item dashboard-admin-nav-item-active">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="2"/>
                        <rect x="14" y="3" width="7" height="7" rx="2"/>
                        <rect x="3" y="14" width="7" height="7" rx="2"/>
                        <rect x="14" y="14" width="7" height="7" rx="2"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
                <a href="#pengelolaan" class="dashboard-admin-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z"/>
                        <path d="M4 17a2.5 2.5 0 0 1 2.5-2.5H20M8 7h7"/>
                    </svg>
                    <span>Modul Pembelajaran</span>
                </a>
                <a href="#pengelolaan" class="dashboard-admin-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                        <path d="M14 3v5h5M8 12h8M8 16h8"/>
                    </svg>
                    <span>Materi</span>
                </a>
                <a href="#pengelolaan" class="dashboard-admin-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M9 11 11 13 15.5 8.5"/>
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M8 18.5V21l4-2 4 2v-2.5"/>
                    </svg>
                    <span>Soal</span>
                </a>
                <a href="#pengelolaan" class="dashboard-admin-nav-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="9"/>
                        <path d="M9 9.5a3 3 0 0 1 5.8 1c0 2-2.8 2.2-2.8 4M12 17.5v.1"/>
                    </svg>
                    <span>Pilihan Jawaban</span>
                </a>
            </nav>

            <div class="dashboard-admin-sidebar-bottom">
                <div class="dashboard-admin-help-card">
                    <div class="dashboard-admin-help-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M12 3 14.5 9.5 21 12l-6.5 2.5L12 21l-2.5-6.5L3 12l6.5-2.5L12 3Z"/>
                        </svg>
                    </div>
                    <strong>Terus tumbuh bersama Lumo</strong>
                    <p>Bangun pengalaman belajar yang menyenangkan untuk setiap anak.</p>
                </div>

                <div class="dashboard-admin-profile">
                    <div class="dashboard-admin-avatar">
                        <?= esc(strtoupper(substr((string) session('name') ?: 'A', 0, 1))) ?>
                    </div>
                    <div class="dashboard-admin-profile-info">
                        <strong><?= esc(session('name') ?: 'Admin Lumo') ?></strong>
                        <span>Administrator</span>
                    </div>
                    <form action="<?= site_url('logout') ?>" method="post" class="dashboard-admin-logout-form" data-dashboard-admin-logout>
                        <?= csrf_field() ?>
                        <button type="submit" class="dashboard-admin-logout" aria-label="Keluar dari akun" title="Keluar">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                <path d="M10 17l5-5-5-5M15 12H3"/>
                                <path d="M12 3h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6"/>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <main class="dashboard-admin-main">
            <header class="dashboard-admin-header">
                <button type="button" class="dashboard-admin-menu-toggle" id="dashboardAdminMenuToggle" aria-label="Buka navigasi" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <div class="dashboard-admin-breadcrumb">
                    <span>Lumo Education</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="m9 18 6-6-6-6"/>
                    </svg>
                    <strong>Dashboard</strong>
                </div>
                <div class="dashboard-admin-header-right">
                    <span class="dashboard-admin-status">
                        <span></span>
                        Panel Administrator
                    </span>
                    <div class="dashboard-admin-header-avatar">
                        <?= esc(strtoupper(substr((string) session('name') ?: 'A', 0, 1))) ?>
                    </div>
                </div>
            </header>

            <div class="dashboard-admin-content">
                <section class="dashboard-admin-welcome" id="ringkasan">
                    <div class="dashboard-admin-welcome-copy">
                        <span class="dashboard-admin-eyebrow">RUANG KERJA ADMIN</span>
                        <h1>Selamat datang, <?= esc(session('name') ?: 'Admin') ?> <span>✦</span></h1>
                        <p>Kelola pengalaman belajar yang lebih bermakna bersama Lumo.</p>
                    </div>
                    <div class="dashboard-admin-welcome-art" aria-hidden="true">
                        <div class="dashboard-admin-art-orbit"></div>
                        <div class="dashboard-admin-art-book">
                            <svg viewBox="0 0 100 100" fill="none">
                                <path d="M15 27c14-5 25-2 35 6v49c-10-8-21-11-35-6V27Z" fill="#FFFFFF" stroke="#C85F1B" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M85 27c-14-5-25-2-35 6v49c10-8 21-11 35-6V27Z" fill="#FCE3CF" stroke="#C85F1B" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M23 39c8-2 14-1 20 3M23 48c8-2 14-1 20 3M58 42c6-4 12-5 19-3M58 51c6-4 12-5 19-3" stroke="#DCA17D" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                        <span class="dashboard-admin-art-spark dashboard-admin-art-spark-one">✦</span>
                        <span class="dashboard-admin-art-spark dashboard-admin-art-spark-two">✧</span>
                    </div>
                </section>

                <section class="dashboard-admin-section">
                    <div class="dashboard-admin-section-heading">
                        <div>
                            <span class="dashboard-admin-eyebrow">GAMBARAN UMUM</span>
                            <h2>Ringkasan konten</h2>
                        </div>
                        <span class="dashboard-admin-section-note">Data belum terhubung</span>
                    </div>

                    <div class="dashboard-admin-stats">
                        <article class="dashboard-admin-stat-card">
                            <div class="dashboard-admin-stat-top">
                                <span class="dashboard-admin-stat-icon dashboard-admin-stat-icon-orange">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z"/>
                                        <path d="M4 17a2.5 2.5 0 0 1 2.5-2.5H20"/>
                                    </svg>
                                </span>
                                <span class="dashboard-admin-stat-label">MODUL</span>
                            </div>
                            <div class="dashboard-admin-stat-value">—</div>
                            <p>Modul pembelajaran</p>
                            <div class="dashboard-admin-stat-footer">Menunggu koneksi data</div>
                        </article>

                        <article class="dashboard-admin-stat-card">
                            <div class="dashboard-admin-stat-top">
                                <span class="dashboard-admin-stat-icon dashboard-admin-stat-icon-green">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                                        <path d="M14 3v5h5M8 12h8M8 16h8"/>
                                    </svg>
                                </span>
                                <span class="dashboard-admin-stat-label">MATERI</span>
                            </div>
                            <div class="dashboard-admin-stat-value">—</div>
                            <p>Materi pembelajaran</p>
                            <div class="dashboard-admin-stat-footer">Menunggu koneksi data</div>
                        </article>

                        <article class="dashboard-admin-stat-card">
                            <div class="dashboard-admin-stat-top">
                                <span class="dashboard-admin-stat-icon dashboard-admin-stat-icon-purple">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <circle cx="12" cy="12" r="9"/>
                                        <path d="M9 11 11 13 15.5 8.5"/>
                                    </svg>
                                </span>
                                <span class="dashboard-admin-stat-label">SOAL</span>
                            </div>
                            <div class="dashboard-admin-stat-value">—</div>
                            <p>Soal latihan</p>
                            <div class="dashboard-admin-stat-footer">Menunggu koneksi data</div>
                        </article>

                        <article class="dashboard-admin-stat-card">
                            <div class="dashboard-admin-stat-top">
                                <span class="dashboard-admin-stat-icon dashboard-admin-stat-icon-blue">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                        <path d="M8 6h13M8 12h13M8 18h13"/>
                                        <circle cx="3.5" cy="6" r=".8" fill="currentColor"/>
                                        <circle cx="3.5" cy="12" r=".8" fill="currentColor"/>
                                        <circle cx="3.5" cy="18" r=".8" fill="currentColor"/>
                                    </svg>
                                </span>
                                <span class="dashboard-admin-stat-label">JAWABAN</span>
                            </div>
                            <div class="dashboard-admin-stat-value">—</div>
                            <p>Pilihan jawaban</p>
                            <div class="dashboard-admin-stat-footer">Menunggu koneksi data</div>
                        </article>
                    </div>
                </section>

                <section class="dashboard-admin-section" id="pengelolaan">
                    <div class="dashboard-admin-section-heading">
                        <div>
                            <span class="dashboard-admin-eyebrow">PENGELOLAAN PEMBELAJARAN</span>
                            <h2>Akses cepat</h2>
                            <p class="dashboard-admin-section-description">Pilih bagian yang ingin kamu kelola.</p>
                        </div>
                    </div>

                    <div class="dashboard-admin-management-grid">
                        <article class="dashboard-admin-management-card">
                            <div class="dashboard-admin-management-icon dashboard-admin-stat-icon-orange">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v16H6.5A2.5 2.5 0 0 0 4 21V5.5Z"/>
                                    <path d="M4 17a2.5 2.5 0 0 1 2.5-2.5H20"/>
                                </svg>
                            </div>
                            <h3>Modul Pembelajaran</h3>
                            <p>Atur kelompok dan struktur pelajaran untuk siswa.</p>
                            <span class="dashboard-admin-coming-soon">Segera tersedia</span>
                        </article>

                        <article class="dashboard-admin-management-card">
                            <div class="dashboard-admin-management-icon dashboard-admin-stat-icon-green">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <path d="M6 3h9l4 4v14H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2Z"/>
                                    <path d="M14 3v5h5M8 12h8M8 16h8"/>
                                </svg>
                            </div>
                            <h3>Materi Pembelajaran</h3>
                            <p>Siapkan materi yang mudah dipahami dan menarik.</p>
                            <span class="dashboard-admin-coming-soon">Segera tersedia</span>
                        </article>

                        <article class="dashboard-admin-management-card">
                            <div class="dashboard-admin-management-icon dashboard-admin-stat-icon-purple">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M9 11 11 13 15.5 8.5"/>
                                </svg>
                            </div>
                            <h3>Soal Latihan</h3>
                            <p>Siapkan latihan untuk membantu siswa memahami materi.</p>
                            <span class="dashboard-admin-coming-soon">Segera tersedia</span>
                        </article>

                        <article class="dashboard-admin-management-card">
                            <div class="dashboard-admin-management-icon dashboard-admin-stat-icon-blue">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                                    <circle cx="12" cy="12" r="9"/>
                                    <path d="M9 9.5a3 3 0 0 1 5.8 1c0 2-2.8 2.2-2.8 4M12 17.5v.1"/>
                                </svg>
                            </div>
                            <h3>Pilihan Jawaban</h3>
                            <p>Atur opsi jawaban untuk setiap soal latihan.</p>
                            <span class="dashboard-admin-coming-soon">Segera tersedia</span>
                        </article>
                    </div>
                </section>

                <footer class="dashboard-admin-footer">
                    <span>© <?= date('Y') ?> Lumo Education</span>
                    <span>Belajar jadi lebih menyenangkan.</span>
                </footer>
            </div>
        </main>
    </div>

    <script src="<?= base_url('assets/js/admin/dashboard-admin.js') ?>" defer></script>
</body>
</html>
