<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        // Kelas warna: b = biru, g = hijau, y = kuning, p = ungu, o = oranye
        $data = [
            'judul' => 'Lumo — Belajar. Jelajahi. Tumbuh.',

            'fitur' => [
                ['b', '🎲', 'Belajar Sambil Bermain',      'Belajar terasa lebih menyenangkan lewat aktivitas interaktif.'],
                ['g', '💡', 'Mudah Dipahami',              'Materi dibuat sederhana supaya anak lebih mudah mengerti.'],
                ['y', '🧭', 'Banyak Hal untuk Dijelajahi', 'Mulai dari matematika, sains, bahasa, sampai hal-hal seru di sekitar kita.'],
                ['p', '⭐', 'Setiap Langkah Berarti',      'Kumpulkan bintang, raih pencapaian, dan lihat perkembanganmu.'],
            ],

            'pelajaran' => [
                ['b', '➗', 'Matematika',            'Angka, hitungan, bentuk, dan banyak tantangan seru.'],
                ['g', '🌱', 'Sains & Alam',          'Kenali hewan, tumbuhan, tubuh kita, dan dunia di sekitar.'],
                ['y', '📖', 'Bahasa',                'Belajar membaca, mengenal kata, dan membuat cerita.'],
                ['o', '🏘️', 'Dunia di Sekitar Kita', 'Kenali lingkungan, profesi, budaya, dan kehidupan sehari-hari.'],
                ['p', '🧩', 'Logika & Kreativitas',  'Asah cara berpikir lewat teka-teki dan tantangan seru.'],
            ],

            'langkah' => [
                ['b', '01', 'Buat Akun',           'Orang tua membuat akun Lumo untuk memulai.'],
                ['y', '02', 'Daftarkan Anak',      'Tambahkan profil anak dan siapkan akun belajarnya.'],
                ['g', '03', 'Yuk, Mulai Belajar!', 'Anak bisa langsung masuk dan menjelajahi dunia belajar Lumo.'],
            ],

            'statistik' => [
                ['⭐ 320', 'Bintang',           64],
                ['🔥 5',   'Hari Belajar',      71],
                ['🏆 8',   'Pencapaian',        40],
                ['📚 12',  'Pelajaran Selesai', 55],
            ],

            'orangtua' => [
                ['g', '🛡️', 'Lingkungan Belajar yang Aman', 'Lumo dibuat sebagai ruang belajar yang nyaman dan ramah untuk anak.'],
                ['b', '📈', 'Pantau Perkembangan Anak',     'Orang tua bisa melihat perjalanan belajar dan perkembangan anak.'],
                ['y', '🎈', 'Dibuat untuk Anak',            'Materi dan tampilan Lumo dirancang supaya mudah dipahami anak usia 7–12 tahun.'],
            ],

            // 1 = jawaban benar
            'pilihan' => [
                ['🐱 Kucing', 0],
                ['🐟 Ikan',   1],
                ['🐘 Gajah',  0],
                ['🦁 Singa',  0],
            ],
        ];

        return view('menu/VHome', $data);
    }
}