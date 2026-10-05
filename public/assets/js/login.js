(function () {
  var form = document.getElementById('formMasuk');
  var email = document.getElementById('email');
  var sandi = document.getElementById('sandi');
  var lihat = document.getElementById('lihatSandi');
  var tombol = document.getElementById('tombolMasuk');
  var maskot = document.querySelector('.mk');

  function tampilError(input, pesan) {
    var el = document.getElementById('err-' + input.id);
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

  function cekEmail() {
    var nilai = email.value.trim();
    if (!nilai) return 'Email wajib diisi.';
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(nilai)) return 'Format email belum benar. Contoh: nama@email.com';
    return '';
  }

  function cekSandi() {
    if (!sandi.value) return 'Kata sandi wajib diisi.';
    if (sandi.value.length < 8) return 'Kata sandi minimal 8 karakter.';
    return '';
  }

  lihat.addEventListener('click', function () {
    var tampak = sandi.type === 'text';
    sandi.type = tampak ? 'password' : 'text';
    lihat.textContent = tampak ? 'Lihat' : 'Sembunyikan';
    lihat.setAttribute('aria-pressed', String(!tampak));
    if (maskot) maskot.classList.toggle('tutup', tampak && document.activeElement === sandi);
  });

  if (maskot) {
    sandi.addEventListener('focus', function () {
      if (sandi.type === 'password') maskot.classList.add('tutup');
    });
    sandi.addEventListener('blur', function () {
      maskot.classList.remove('tutup');
    });
  }

  email.addEventListener('blur', function () {
    if (email.value) tampilError(email, cekEmail());
  });

  sandi.addEventListener('blur', function () {
    if (sandi.value) tampilError(sandi, cekSandi());
  });

  email.addEventListener('input', function () {
    if (email.hasAttribute('aria-invalid') && !cekEmail()) tampilError(email, '');
  });

  sandi.addEventListener('input', function () {
    if (sandi.hasAttribute('aria-invalid') && !cekSandi()) tampilError(sandi, '');
  });

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    var pesanEmail = cekEmail();
    var pesanSandi = cekSandi();
    tampilError(email, pesanEmail);
    tampilError(sandi, pesanSandi);

    if (pesanEmail || pesanSandi) {
      (pesanEmail ? email : sandi).focus();
      return;
    }

    tombol.classList.add('memuat');
    tombol.textContent = 'Memproses';

    setTimeout(function () {
      tombol.classList.remove('memuat');
      tombol.textContent = 'Masuk';
    }, 1200);
  });
})();