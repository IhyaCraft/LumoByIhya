(function () {
    var form = document.getElementById('formDaftar');
    var nama = document.getElementById('nama');
    var email = document.getElementById('email');
    var sandi = document.getElementById('sandi');
    var lihat = document.getElementById('lihatSandi');
    var tombol = document.getElementById('tombolDaftar');
    var loadingDaftar = document.getElementById('loadingDaftar');
    var maskot = document.querySelector('.mk');
    var kembali = document.querySelector('.kembali');

    if (!form || !nama || !email || !sandi || !tombol) {
        return;
    }

    function tampilError(input, pesan) {
        var el = document.getElementById('err-' + input.id);

        if (!el) {
            return;
        }

        if (pesan) {
            input.setAttribute('aria-invalid', 'true');
            el.textContent = '⚠ ' + pesan;
            el.classList.remove('muncul');
            void el.offsetWidth;
            el.classList.add('muncul');
        } else {
            input.removeAttribute('aria-invalid');
            el.textContent = '';
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
        if (!sandi.value) {
            return 'Kata sandi wajib diisi.';
        }

        if (sandi.value.length < 8) {
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

    if (kembali && maskot) {
        kembali.addEventListener('click', function () {
            maskot.classList.add('pamit');
        });
    }

    nama.addEventListener('blur', function () {
        if (nama.value) {
            tampilError(nama, cekNama());
        }
    });

    email.addEventListener('blur', function () {
        if (email.value) {
            tampilError(email, cekEmail());
        }
    });

    sandi.addEventListener('blur', function () {
        if (sandi.value) {
            tampilError(sandi, cekSandi());
        }
    });

    nama.addEventListener('input', function () {
        if (nama.hasAttribute('aria-invalid') && !cekNama()) {
            tampilError(nama, '');
        }
    });

    email.addEventListener('input', function () {
        if (email.hasAttribute('aria-invalid') && !cekEmail()) {
            tampilError(email, '');
        }
    });

    sandi.addEventListener('input', function () {
        if (sandi.hasAttribute('aria-invalid') && !cekSandi()) {
            tampilError(sandi, '');
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

        tombol.classList.add('memuat');
        tombol.textContent = 'Mendaftar';
        tombol.disabled = true;

        if (loadingDaftar) {
            loadingDaftar.classList.add('aktif');
            loadingDaftar.setAttribute('aria-hidden', 'false');
        }
    });
})();