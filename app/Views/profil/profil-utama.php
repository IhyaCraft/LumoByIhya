<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<title>Profil | Lumo</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Nunito:wght@700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="css/home-sudah-login.css">
</head>
<body class="home-sudah-login">
<div class="backdrop" aria-hidden="true">
  <div class="blob a" data-depth="30"></div>
  <div class="blob b" data-depth="-24"></div>
  <div class="blob c" data-depth="16"></div>
</div>

<header class="topbar">
  <div class="topbar-inner">
    <a class="brand" href="/beranda"><i></i>Lumo</a>
    <a class="back" href="/beranda">Kembali ke beranda</a>
  </div>
</header>

<main>
  <section class="card hero reveal" data-tilt aria-labelledby="hello">
    <div class="avatar-wrap">
      <div class="halo"></div>
      <div class="ring"></div>
      <div class="spark"></div>
      <div class="spark s2"></div>
      <div class="avatar" role="img" aria-label="Avatar pengguna">
        <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
          <rect width="200" height="200" fill="#FCE3CF"/>
          <circle cx="40" cy="40" r="26" fill="#F9D3B3"/>
          <circle cx="168" cy="150" r="34" fill="#F9D3B3"/>
          <path d="M34 200c4-34 32-52 66-52s62 18 66 52z" fill="#C85F1B"/>
          <path d="M84 150h32v14c0 8-7 14-16 14s-16-6-16-14z" fill="#F4C7A1"/>
          <ellipse cx="100" cy="102" rx="46" ry="48" fill="#FBD9B8"/>
          <path d="M52 100c-4-36 22-58 50-58 30 0 52 20 46 58-10-18-26-26-44-26-20 0-40 8-52 26z" fill="#4A2C1A"/>
          <circle cx="100" cy="40" r="12" fill="#4A2C1A"/>
          <ellipse cx="82" cy="104" rx="6" ry="7.5" fill="#2B2B33" class="eye"/>
          <ellipse cx="118" cy="104" rx="6" ry="7.5" fill="#2B2B33" class="eye"/>
          <circle cx="84" cy="101" r="2" fill="#fff"/>
          <circle cx="120" cy="101" r="2" fill="#fff"/>
          <ellipse cx="70" cy="118" rx="8" ry="5" fill="#F29A6B" opacity=".65"/>
          <ellipse cx="130" cy="118" rx="8" ry="5" fill="#F29A6B" opacity=".65"/>
          <path d="M90 123q10 9 20 0" stroke="#2B2B33" stroke-width="3.5" fill="none" stroke-linecap="round"/>
        </svg>
      </div>
    </div>
    <div>
      <h1 class="hello" id="hello"></h1>
      <p class="who" id="fullname"></p>
      <p class="mail" id="email"></p>
      <span class="status" id="status" hidden></span>
      <div><a class="btn primary" href="/profil/edit" data-ripple>
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
        Edit Profil</a></div>
    </div>
  </section>

  <section class="card reveal" data-tilt aria-labelledby="progres">
    <div class="sec-head">
      <div>
        <h2 id="progres">Progres Belajarku</h2>
        <p>Ringkasan perjalanan belajarmu di Lumo.</p>
      </div>
    </div>
    <div class="stats">
      <div class="stat">
        <div class="ico"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 5a2 2 0 0 1 2-2h13v16H6a2 2 0 0 0-2 2z"/><path d="M9 8l2 2 4-4"/></svg></div>
        <div><strong id="lessons" data-count>–</strong><span>Pelajaran selesai</span></div>
      </div>
      <div class="stat">
        <div class="ico"><svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="9" r="6"/><path d="M8.5 14L7 22l5-3 5 3-1.5-8"/></svg></div>
        <div><strong id="achievements" data-count>–</strong><span>Pencapaian diraih</span></div>
      </div>
    </div>
    <div class="target" id="target" hidden>
      <div class="target-top"><span id="targetLabel"></span><span id="targetPct"></span></div>
      <div class="track" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="targetTrack"><div class="fill" id="targetFill"></div></div>
    </div>
  </section>

  <section class="card reveal" data-tilt aria-labelledby="aktivitas">
    <div class="sec-head">
      <div>
        <h2 id="aktivitas">Aktivitas 7 Hari Terakhir</h2>
        <p>Banyaknya pelajaran yang kamu selesaikan tiap hari.</p>
      </div>
      <button class="btn ghost" id="preview" type="button" data-ripple>Lihat contoh tampilan</button>
    </div>
    <div class="chart-box">
      <div class="empty" id="empty">
        <svg width="96" height="96" viewBox="0 0 96 96" fill="none" aria-hidden="true">
          <rect x="14" y="52" width="14" height="30" rx="7" fill="#FCE3CF"/>
          <rect x="41" y="34" width="14" height="48" rx="7" fill="#F6C79F"/>
          <rect x="68" y="16" width="14" height="66" rx="7" fill="#C85F1B"/>
          <circle cx="75" cy="10" r="4" fill="#C85F1B"/>
        </svg>
        <h3>Perjalanan belajarmu dimulai di sini!</h3>
        <p>Yuk, selesaikan pelajaran pertamamu untuk melihat progresmu.</p>
      </div>
      <svg class="chart" id="chart" hidden role="img" aria-label="Grafik aktivitas belajar 7 hari terakhir"></svg>
      <div class="tip" id="tip"></div>
    </div>
  </section>

  <section class="card reveal" data-tilt aria-labelledby="akun">
    <div class="sec-head">
      <div>
        <h2 id="akun">Pengaturan Akun</h2>
        <p>Atur keamanan dan keluar dari akunmu.</p>
      </div>
    </div>
    <div class="settings">
      <div class="tile">
        <div class="ico"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="4" y="11" width="16" height="10" rx="3"/><path d="M8 11V8a4 4 0 0 1 8 0v3"/></svg></div>
        <h3>Keamanan akun</h3>
        <p>Ganti kata sandi supaya akunmu tetap aman.</p>
        <a class="btn ghost" href="/ubah-kata-sandi" data-ripple>Ubah kata sandi</a>
      </div>
      <div class="tile">
        <div class="ico"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 21H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3"/><path d="M16 17l5-5-5-5"/><path d="M21 12H9"/></svg></div>
        <h3>Keluar dari akun</h3>
        <p>Selesai belajar? Sampai jumpa lagi di Lumo!</p>
        <form method="post" action="/logout" id="logoutForm">
          <input type="hidden" name="csrf_token_name" id="csrf" value="">
          <button class="btn danger" type="submit" data-ripple>Keluar</button>
        </form>
      </div>
    </div>
  </section>
</main>

<div class="toast" id="toast" role="status" aria-live="polite"></div>

<script src="js/home-sudah-login.js" defer></script>
</body>
</html>