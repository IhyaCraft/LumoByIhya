(function () {
    var form = document.getElementById('formMasuk');
    var email = document.getElementById('email');
    var password = document.getElementById('password');
    var lihat = document.getElementById('lihatSandi');
    var tombol = document.getElementById('tombolMasuk');
    var maskot = document.querySelector('.mk');

    if (!form || !email || !password || !tombol) {
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
            el.classList.remove('muncul');
        }
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

    function cekPassword() {
        if (!password.value) {
            return 'Kata sandi wajib diisi.';
        }

        if (password.value.length < 8) {
            return 'Kata sandi minimal 8 karakter.';
        }

        return '';
    }

    if (lihat) {
        lihat.addEventListener('click', function () {
            var tampil = password.type === 'text';

            password.type = tampil ? 'password' : 'text';
            lihat.textContent = tampil ? 'Lihat' : 'Sembunyikan';
            lihat.setAttribute('aria-pressed', String(!tampil));

            if (maskot) {
                maskot.classList.toggle('tutup', !tampil);
            }
        });
    }

    if (maskot) {
        password.addEventListener('focus', function () {
            if (password.type === 'password') {
                maskot.classList.add('tutup');
            }
        });

        password.addEventListener('blur', function () {
            maskot.classList.remove('tutup');
        });
    }

    email.addEventListener('blur', function () {
        if (email.value.trim()) {
            tampilError(email, cekEmail());
        }
    });

    password.addEventListener('blur', function () {
        if (password.value) {
            tampilError(password, cekPassword());
        }
    });

    email.addEventListener('input', function () {
        if (email.hasAttribute('aria-invalid')) {
            tampilError(email, cekEmail());
        }
    });

    password.addEventListener('input', function () {
        if (password.hasAttribute('aria-invalid')) {
            tampilError(password, cekPassword());
        }
    });

    form.addEventListener('submit', function (e) {
        var pesanEmail = cekEmail();
        var pesanPassword = cekPassword();

        tampilError(email, pesanEmail);
        tampilError(password, pesanPassword);

        if (pesanEmail || pesanPassword) {
            e.preventDefault();

            if (pesanEmail) {
                email.focus();
            } else {
                password.focus();
            }

            return;
        }

        tombol.classList.add('memuat');
        tombol.textContent = 'Memproses...';
        tombol.disabled = true;
    });
})();
