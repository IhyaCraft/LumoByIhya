<?= $this->extend('layouts/VMain') ?>


<?= $this->section('konten') ?>

<?php
$nama       = $nama ?? session()->get('name') ?? 'Teman';
$bintang    = $bintang ?? 0;
$pencapaian = $pencapaian ?? 0;
$topik      = $topik ?? 'Sains & Alam';
$terakhir   = $terakhir ?? null;
?>

<section class="hero" id="beranda">
  <div class="wrap hg">
    <div>
      <span class="ey">Senang bertemu lagi!</span>
      <h1>Halo, <?= esc($nama) ?>!</h1>
      <p class="lead">
        Hari ini mau belajar apa? Lanjutkan petualanganmu bersama Lumo, atau pilih pelajaran baru.
      </p>

      <div class="cta">
        <a class="btn pri" href="<?= esc($terakhir['url'] ?? site_url('pelajaran'), 'attr') ?>">
          Lanjut Belajar
        </a>
        <a class="btn sec" href="#pelajaran">Pilih Pelajaran</a>
      </div>
    </div>

    <div class="stage">
      <?= view('partials/VMaskot', ['kelas' => 'mascot', 'lengkap' => true]) ?>
      <div class="fc f1">⭐ <?= esc($bintang) ?> Bintang</div>
      <div class="fc f2">🌱 <?= esc($topik) ?></div>
      <div class="fc f3">🏆 <?= esc($pencapaian) ?> Pencapaian</div>
    </div>
  </div>
</section>

<?php if (! empty($terakhir)): ?>
<section id="lanjut">
  <div class="wrap">
    <div class="card">
      <div class="lj">
        <div class="tx">
          <span class="ey">Terakhir kamu pelajari</span>
          <h3>
            <?= esc($terakhir['judul']) ?>
            <small>· <?= esc($terakhir['topik']) ?></small>
          </h3>

          <div
            class="pg-bar"
            role="progressbar"
            aria-valuemin="0"
            aria-valuemax="100"
            aria-valuenow="<?= (int) $terakhir['persen'] ?>"
            aria-label="Kemajuan belajar"
          >
            <u style="width:<?= (int) $terakhir['persen'] ?>%"></u>
          </div>

          <p style="margin-top:8px">
            <?= (int) $terakhir['persen'] ?>% selesai
          </p>
        </div>

        <a class="btn pri" href="<?= esc($terakhir['url'], 'attr') ?>">
          Lanjutkan
        </a>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section id="pelajaran">
  <div class="wrap">
    <h2>Yuk, jelajahi pelajaran!</h2>
    <p class="lead">
      Temukan hal baru dan pilih pelajaran yang ingin kamu pelajari hari ini.
    </p>

    <div class="g5">
      <?php foreach ($pelajaran as $p): ?>
        <?php [$warna, $ikon, $nama_p, $isi] = $p; $url = $p[4] ?? '#'; ?>

        <a class="card" href="<?= esc($url, 'attr') ?>">
          <div class="ic <?= esc($warna, 'attr') ?>"><?= $ikon ?></div>
          <h3><?= esc($nama_p) ?></h3>
          <p><?= esc($isi) ?></p>
          <div class="go">
            <span>Mulai belajar</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="pencapaian">
  <div class="wrap">
    <div class="dm">
      <div>
        <h2>Latihan singkat hari ini</h2>
        <p class="lead">
          Jawab pertanyaan, kumpulkan bintang, dan lihat sudah sejauh mana kamu belajar.
        </p>
        <p class="lead" style="margin-top:16px">
          Pilih satu jawaban, lalu tekan Jawab.
        </p>
      </div>

      <div class="qz" id="qz">
        <div class="qh">
          <span>Yuk, Kenali Hewan!</span>
          <span>Pertanyaan 4 dari 5</span>
        </div>

        <div class="bar">
          <i id="pb"></i>
        </div>

        <h3>Manakah hewan yang hidup di air?</h3>

        <div class="opts" role="group" aria-label="Pilihan jawaban">
          <?php foreach ($pilihan as [$teks, $benar]): ?>
            <button type="button" class="opt" data-v="<?= (int) $benar ?>">
              <?= esc($teks) ?>
            </button>
          <?php endforeach; ?>
        </div>

        <div class="fb" id="fb" role="status" aria-live="polite">
          Pilih satu jawaban dulu, ya.
        </div>

        <div class="cta">
          <button type="button" class="btn pri" id="jw">Jawab</button>
          <button type="button" class="btn sec" id="nx">Selanjutnya</button>
        </div>
      </div>
    </div>

    <h2 style="margin-top:80px">Pencapaianmu sejauh ini</h2>
    <p class="lead">
      Hebat, <?= esc($nama) ?>! Terus kumpulkan bintang di setiap belajar.
    </p>

    <div class="stats">
      <?php foreach ($statistik as [$angka, $label, $persen]): ?>
        <div class="card stat">
          <b><?= esc($angka) ?></b>
          <span><?= esc($label) ?></span>
          <i>
            <u style="width:<?= (int) $persen ?>%"></u>
          </i>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php if (! empty($orangtua)): ?>
<section id="tentang-orangtua">
  <div class="wrap">
    <h2>Untuk orang tua</h2>

    <div class="pg">
      <?php foreach ($orangtua as [$warna, $ikon, $nama_o, $isi]): ?>
        <div class="card">
          <div class="ic <?= esc($warna, 'attr') ?>"><?= $ikon ?></div>
          <h3><?= esc($nama_o) ?></h3>
          <p><?= esc($isi) ?></p>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section>
  <div class="wrap">
    <div class="fin">
      <div>
        <h2>Siap lanjut belajar?</h2>
        <p class="lead">
          Satu pelajaran kecil hari ini sudah cukup untuk menambah bintangmu.
        </p>

        <div class="cta">
          <a class="btn pri" href="<?= esc($terakhir['url'] ?? site_url('pelajaran'), 'attr') ?>">
            Lanjut Belajar
          </a>
          <a class="btn sec" href="#pelajaran">Pilih Pelajaran Lain</a>
        </div>
      </div>

      <?= view('partials/VMaskot', ['lengkap' => false]) ?>
    </div>
  </div>
</section>
<script>
<?= $this->endSection() ?>