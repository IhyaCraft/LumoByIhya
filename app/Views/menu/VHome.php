<?= $this->extend('layouts/VMain') ?>

<?= $this->section('konten') ?>

<!-- HERO -->
<section class="hero" id="beranda"><div class="wrap hg">
  <div>
    <span class="ey">Teman belajar seru untuk anak</span>
    <h1>Belajar jadi lebih seru!</h1>
    <p class="lead">Lumo membantu anak belajar, bermain, dan menemukan hal-hal baru dengan cara yang menyenangkan.</p>
    <div class="cta">
      <a class="btn pri" href="<?=site_url('daftar')?>">Mulai Sekarang</a>
      <a class="btn sec" href="#pengalaman">Kenalan dengan Lumo</a>
    </div>
  </div>
  <div class="stage">
    <?= view('partials/VMaskot', ['kelas' => 'mascot', 'lengkap' => true]) ?>
    <div class="fc f1">⭐ 320 Bintang</div>
    <div class="fc f2">🌱 Sains &amp; Alam</div>
    <div class="fc f3">🏆 5 Pencapaian</div>
  </div>
</div></section>

<!-- KENAPA LUMO -->
<section id="tentang"><div class="wrap">
  <h2>Kenapa belajar di Lumo?</h2>
  <p class="lead">Belajar yang nyaman buat anak, dan mudah diikuti orang tua.</p>
  <div class="g4">
    <?php foreach ($fitur as [$warna, $ikon, $nama, $isi]): ?>
      <div class="card">
        <div class="ic <?= $warna ?>"><?= $ikon ?></div>
        <h3><?= esc($nama) ?></h3>
        <p><?= esc($isi) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div></section>

<!-- JELAJAHI PELAJARAN -->
<section id="pelajaran"><div class="wrap">
  <h2>Yuk, jelajahi pelajaran!</h2>
  <p class="lead">Temukan hal baru dan pilih pelajaran yang ingin kamu pelajari hari ini.</p>
  <div class="g5">
    <?php foreach ($pelajaran as [$warna, $ikon, $nama, $isi]): ?>
      <a class="card" href="#">
        <div class="ic <?= $warna ?>"><?= $ikon ?></div>
        <h3><?= esc($nama) ?></h3>
        <p><?= esc($isi) ?></p>
        <div class="go"><span>Lihat pelajaran</span></div>
      </a>
    <?php endforeach; ?>
  </div>
</div></section>

<!-- CARA KERJA -->
<section id="cara-kerja"><div class="wrap">
  <h2>Mulainya gampang, kok!</h2>
  <p class="lead">Tiga langkah saja, orang tua bisa langsung menyiapkan semuanya.</p>
  <div class="steps">
    <?php foreach ($langkah as $i => [$warna, $no, $nama, $isi]): ?>
      <div class="card st">
        <div class="n <?= $warna ?>"><?= $no ?></div>
        <h3><?= esc($nama) ?></h3>
        <p><?= esc($isi) ?></p>
      </div>
      <?php if ($i < count($langkah) - 1): ?><div class="ar" aria-hidden="true">→</div><?php endif; ?>
    <?php endforeach; ?>
  </div>
</div></section>

<!-- CONTOH PENGALAMAN BELAJAR + PENCAPAIAN -->
<section id="pengalaman"><div class="wrap">
  <div class="dm">
    <div>
      <h2>Belajarnya seperti apa, sih?</h2>
      <p class="lead">Di Lumo, anak tidak hanya membaca. Mereka juga diajak menjawab pertanyaan, mencoba aktivitas, dan menemukan hal baru.</p>
      <p class="lead" style="margin-top:16px">Coba sendiri contohnya di samping. Pilih satu jawaban, lalu tekan Jawab.</p>
    </div>
    <div class="qz" id="qz">
      <div class="qh"><span>Yuk, Kenali Hewan!</span><span>Pertanyaan 4 dari 5</span></div>
      <div class="bar"><i id="pb"></i></div>
      <h3>Manakah hewan yang hidup di air?</h3>
      <div class="opts" role="group" aria-label="Pilihan jawaban">
        <?php foreach ($pilihan as [$teks, $benar]): ?>
          <button class="opt" data-v="<?= $benar ?>"><?= esc($teks) ?></button>
        <?php endforeach; ?>
      </div>
      <div class="fb" id="fb" role="status" aria-live="polite">Pilih satu jawaban dulu, ya.</div>
      <div class="cta">
        <button class="btn pri" id="jw">Jawab</button>
        <button class="btn sec" id="nx">Selanjutnya</button>
      </div>
    </div>
  </div>

  <h2 style="margin-top:80px">Setiap belajar, ada pencapaian baru!</h2>
  <p class="lead">Anak bisa melihat sendiri sejauh mana perjalanan belajarnya.</p>
  <div class="stats">
    <?php foreach ($statistik as [$angka, $label, $persen]): ?>
      <div class="card stat">
        <b><?= esc($angka) ?></b>
        <span><?= esc($label) ?></span>
        <i><u style="width:<?= (int) $persen ?>%"></u></i>
      </div>
    <?php endforeach; ?>
  </div>
</div></section>

<!-- UNTUK ORANG TUA -->
<section><div class="wrap">
  <h2>Belajar untuk anak, tenang untuk orang tua.</h2>
  <div class="pg">
    <?php foreach ($orangtua as [$warna, $ikon, $nama, $isi]): ?>
      <div class="card">
        <div class="ic <?= $warna ?>"><?= $ikon ?></div>
        <h3><?= esc($nama) ?></h3>
        <p><?= esc($isi) ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</div></section>

<!-- CTA AKHIR -->
<section id="daftar"><div class="wrap"><div class="fin">
  <div>
    <h2>Siap mulai perjalanan belajar?</h2>
    <p class="lead">Yuk, ajak anak menemukan cara belajar yang lebih seru bersama Lumo.</p>
    <div class="cta">
      <a class="btn pri" href="<?=site_url('daftar')?>">Daftarkan Anak</a>
      <a class="btn sec" href="#">Mulai Perjalanan</a>
    </div>
  </div>
  <?= view('partials/VMaskot', ['lengkap' => false]) ?>
</div></div></section>

<?= $this->endSection() ?>