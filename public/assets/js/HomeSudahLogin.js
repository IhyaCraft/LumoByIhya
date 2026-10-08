(function () {
  var halus = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var kursor = window.matchMedia('(hover: hover) and (pointer: fine)').matches;
  var hm = document.querySelector('.hm');
  var nama = hm ? hm.getAttribute('data-nama') || 'Teman' : 'Teman';

  function $(s, r) {
    return (r || document).querySelector(s);
  }

  function $$(s, r) {
    return Array.prototype.slice.call((r || document).querySelectorAll(s));
  }

  var waktu = $('#waktu');
  if (waktu) {
    var jam = new Date().getHours();
    var sapaan = 'Selamat malam 🌙';
    if (jam >= 4 && jam < 11) sapaan = 'Selamat pagi ☀️';
    else if (jam >= 11 && jam < 15) sapaan = 'Selamat siang 🌤️';
    else if (jam >= 15 && jam < 18) sapaan = 'Selamat sore 🌇';
    waktu.textContent = sapaan;
  }

  var bar = $('.hm-bar i');
  var angka = $('#angkaPersen');

  function hitung(el, awal, akhir, sisa, lama) {
    var mulai = null;
    function jalan(t) {
      if (!mulai) mulai = t;
      var p = Math.min((t - mulai) / lama, 1);
      var e = 1 - Math.pow(1 - p, 3);
      el.textContent = awal + Math.round(akhir * e) + sisa;
      if (p < 1) requestAnimationFrame(jalan);
    }
    requestAnimationFrame(jalan);
  }

  if (bar) {
    var nilai = parseInt(bar.getAttribute('data-nilai') || '0', 10);
    if (halus) {
      if (angka) angka.textContent = '0';
      setTimeout(function () {
        bar.style.width = nilai + '%';
        if (angka) hitung(angka, '', nilai, '', 1400);
      }, 500);
    } else {
      bar.style.width = nilai + '%';
    }
  }

  var warna = ['#F2A65A', '#7FB5E8', '#8CCB93', '#F2D16B', '#B9A4E6'];

  function konfeti(x, y, n) {
    if (!halus) return;
    for (var i = 0; i < n; i++) {
      var p = document.createElement('span');
      p.className = 'hm-konfeti';
      p.style.left = x + 'px';
      p.style.top = y + 'px';
      p.style.background = warna[i % warna.length];
      p.style.width = 6 + Math.random() * 6 + 'px';
      p.style.height = 8 + Math.random() * 8 + 'px';
      document.body.appendChild(p);
      var sudut = Math.random() * Math.PI * 2;
      var jarak = 60 + Math.random() * 120;
      var dx = Math.cos(sudut) * jarak;
      var dy = Math.sin(sudut) * jarak - 50;
      var a = p.animate([
        { transform: 'translate(0, 0) rotate(0deg)', opacity: 1 },
        { transform: 'translate(' + dx + 'px, ' + dy + 'px) rotate(' + Math.random() * 540 + 'deg)', opacity: 1, offset: 0.6 },
        { transform: 'translate(' + dx * 1.1 + 'px, ' + (dy + 130) + 'px) rotate(' + Math.random() * 720 + 'deg)', opacity: 0 }
      ], { duration: 1000 + Math.random() * 500, easing: 'cubic-bezier(0.2, 0.7, 0.3, 1)' });
      a.onfinish = (function (el) {
        return function () {
          el.remove();
        };
      })(p);
    }
  }

  var mk = $('.hm-mk');
  var gel = $('#gel');
  var pesan = ['Halo, ' + nama + '! 👋', 'Yuk, lanjut belajar!', 'Kamu hebat hari ini!', 'Mau belajar apa dulu?'];
  var urut = 0;
  var tunggu;

  if (mk && gel) {
    mk.setAttribute('tabindex', '0');
    mk.setAttribute('role', 'button');
    mk.setAttribute('aria-label', 'Sapa Lumo');

    var sapa = function () {
      var r = mk.getBoundingClientRect();
      gel.textContent = pesan[urut++ % pesan.length];
      gel.classList.add('lihat');
      mk.classList.remove('lompat');
      void mk.getBoundingClientRect();
      mk.classList.add('lompat');
      konfeti(r.left + r.width / 2, r.top + r.height / 3, 16);
      clearTimeout(tunggu);
      tunggu = setTimeout(function () {
        gel.classList.remove('lihat');
      }, 2400);
    };

    mk.addEventListener('click', sapa);
    mk.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        sapa();
      }
    });
    mk.addEventListener('animationend', function (e) {
      if (e.animationName === 'hmLompat') mk.classList.remove('lompat');
    });
  }

  document.addEventListener('pointerdown', function (e) {
    var t = e.target.closest('.hm .btn, .hm-kartu, .hm-nav a:not(.hm-logo)');
    if (!t || !halus) return;
    var r = t.getBoundingClientRect();
    var s = document.createElement('span');
    s.className = 'hm-riak';
    s.style.left = e.clientX - r.left + 'px';
    s.style.top = e.clientY - r.top + 'px';
    t.appendChild(s);
    setTimeout(function () {
      s.remove();
    }, 700);
  });

  if (!halus) return;

  document.documentElement.classList.add('js');

  var daftar = $$('[data-rv]');
  var kelompok = {};

  daftar.forEach(function (el) {
    var induk = el.parentNode;
    var kunci = induk.className || 'x';
    kelompok[kunci] = (kelompok[kunci] || 0) + 1;
    el.style.setProperty('--d', (kelompok[kunci] - 1) * 90 + 'ms');
  });

  var stat = $$('[data-hitung]');
  stat.forEach(function (b) {
    var m = b.textContent.match(/^(\D*)(\d+)(.*)$/);
    if (m) {
      b.setAttribute('data-awal', m[1]);
      b.setAttribute('data-akhir', m[2]);
      b.setAttribute('data-sisa', m[3]);
      b.textContent = m[1] + '0' + m[3];
    }
  });

  var pengintai = new IntersectionObserver(function (es) {
    es.forEach(function (e) {
      if (!e.isIntersecting) return;
      var el = e.target;
      el.classList.add('tampil');
      pengintai.unobserve(el);
      var b = $('[data-hitung]', el);
      if (b && b.hasAttribute('data-akhir')) {
        hitung(b, b.getAttribute('data-awal'), parseInt(b.getAttribute('data-akhir'), 10), b.getAttribute('data-sisa'), 1300);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -6% 0px' });

  daftar.forEach(function (el) {
    pengintai.observe(el);
  });

  if (mk) {
    setInterval(function () {
      var mata = $$('rect[width="14"]', mk);
      mata.forEach(function (m) {
        m.classList.add('kedip');
      });
      setTimeout(function () {
        mata.forEach(function (m) {
          m.classList.remove('kedip');
        });
      }, 150);
    }, 4000);
  }

  if (!kursor) return;

  $$('[data-tilt]').forEach(function (k) {
    var g = document.createElement('span');
    g.className = 'glow';
    g.setAttribute('aria-hidden', 'true');
    k.appendChild(g);

    k.addEventListener('mousemove', function (e) {
      var r = k.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width;
      var y = (e.clientY - r.top) / r.height;
      k.style.transform = 'perspective(800px) rotateX(' + (0.5 - y) * 8 + 'deg) rotateY(' + (x - 0.5) * 10 + 'deg) translateY(-4px)';
      k.style.setProperty('--gx', x * 100 + '%');
      k.style.setProperty('--gy', y * 100 + '%');
    });

    k.addEventListener('mouseleave', function () {
      k.style.transform = '';
    });
  });

  var lanjut = $('.hm-lanjut');
  if (lanjut) {
    lanjut.addEventListener('mousemove', function (e) {
      var r = lanjut.getBoundingClientRect();
      var x = (e.clientX - r.left) / r.width - 0.5;
      var y = (e.clientY - r.top) / r.height - 0.5;
      lanjut.style.transform = 'perspective(1000px) rotateX(' + -y * 3 + 'deg) rotateY(' + x * 4 + 'deg)';
    });
    lanjut.addEventListener('mouseleave', function () {
      lanjut.style.transform = '';
    });
  }

  var kotak = $('.hm-maskot');
  var kx = 0;
  var ky = 0;
  var sibuk = false;

  function ikuti() {
    sibuk = false;
    if (!mk) return;
    var r = mk.getBoundingClientRect();
    var dx = Math.max(-1, Math.min(1, (kx - (r.left + r.width / 2)) / 260)) * 4;
    var dy = Math.max(-1, Math.min(1, (ky - (r.top + r.height / 2)) / 260)) * 3;
    $$('rect[width="14"], rect[width="5"]', mk).forEach(function (m) {
      m.style.translate = dx + 'px ' + dy + 'px';
    });
  }

  document.addEventListener('mousemove', function (e) {
    kx = e.clientX;
    ky = e.clientY;
    if (!sibuk) {
      sibuk = true;
      requestAnimationFrame(ikuti);
    }
    if (kotak) {
      var r = kotak.getBoundingClientRect();
      kotak.style.setProperty('--mx', ((e.clientX - r.left) / r.width) * 100 + '%');
      kotak.style.setProperty('--my', ((e.clientY - r.top) / r.height) * 100 + '%');
    }
  });
})();