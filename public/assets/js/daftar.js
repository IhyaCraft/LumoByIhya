
(function () {
    var form = document.getElementById('formDaftar');
    var nama = document.getElementById('nama');
    var email = document.getElementById('email');
    var sandi = document.getElementById('sandi');
    var lihat = document.getElementById('lihatSandi');
    var tombol = document.getElementById('tombolDaftar');
    var loadingDaftar = document.getElementById('loadingDaftar');
    var maskot = document.querySelector('.mk');

    if (!form || !nama || !email || !sandi || !tombol) {
        return;
    }

    function tampilError(input, pesan) {
    var errorId = input.id === 'sandi' ? 'err-password' : 'err-' + input.id;
    var el = document.getElementById(errorId);

    if (!el) {
        return;
    }

    if (pesan) {
        input.setAttribute('aria-invalid', 'true');
        el.textContent = '⚠ ' + pesan;
        el.classList.add('muncul');
    } else {
        input.removeAttribute('aria-invalid');
        el.textContent = '';
        el.classList.remove('muncul');
    }
}

    function cekNama() {
        var nilai = nama.value.trim();

        if (!nilai) {
            return 'Nama wajib diisi.';
        }

        if (nilai.length < 3) {
            return 'Nama minimal 3 karakter.';
        }

        return '';
    }

    function cekEmail() {
        var nilai = email.value.trim();

        if (!nilai) {
            return 'Email wajib diisi.';
        }

        if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(nilai)) {
            return 'Format email belum benar. Contoh: nama@email.com';
        }

        return '';
    }

    function cekSandi() {
        var nilai = sandi.value;

        if (!nilai) {
            return 'Kata sandi wajib diisi.';
        }

        if (nilai.length < 8) {
            return 'Kata sandi minimal 8 karakter.';
        }

        return '';
    }

    if (lihat) {
        lihat.addEventListener('click', function () {
            var tampak = sandi.type === 'text';

            sandi.type = tampak ? 'password' : 'text';
            lihat.textContent = tampak ? 'Lihat' : 'Sembunyikan';
            lihat.setAttribute('aria-pressed', String(!tampak));

            if (maskot) {
                maskot.classList.toggle('tutup', !tampak);
            }
        });
    }

    nama.addEventListener('blur', function () {
        tampilError(nama, cekNama());
    });

    email.addEventListener('blur', function () {
        tampilError(email, cekEmail());
    });

    sandi.addEventListener('blur', function () {
        tampilError(sandi, cekSandi());
    });

nama.addEventListener('input', function () {
    if (nama.hasAttribute('aria-invalid')) {
        tampilError(nama, cekNama());
    }
});
    email.addEventListener('input', function () {
        if (email.hasAttribute('aria-invalid')) {
            tampilError(email, cekEmail());
        }
    });

    sandi.addEventListener('input', function () {
        if (sandi.hasAttribute('aria-invalid')) {
            tampilError(sandi, cekSandi());
        }
    });

    form.addEventListener('submit', function (e) {
        var pesanNama = cekNama();
        var pesanEmail = cekEmail();
        var pesanSandi = cekSandi();

        tampilError(nama, pesanNama);
        tampilError(email, pesanEmail);
        tampilError(sandi, pesanSandi);

        if (pesanNama || pesanEmail || pesanSandi) {
            e.preventDefault();

            if (pesanNama) {
                nama.focus();
            } else if (pesanEmail) {
                email.focus();
            } else {
                sandi.focus();
            }

            return;
        }

        tombol.textContent = 'Memproses...';
        tombol.disabled = true;
        tombol.classList.add('memuat');

        if (loadingDaftar) {
            loadingDaftar.classList.add('aktif');
            loadingDaftar.setAttribute('aria-hidden', 'false');
        }
    });
})();
