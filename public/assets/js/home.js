(function () {
  var halus = !window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var kursor = window.matchMedia('(hover: hover) and (pointer: fine)').matches;

  function $(s, r) {
    return (r || document).querySelector(s);
  }

  function $$(s, r) {
    return Array.prototype.slice.call((r || document).querySelectorAll(s));
  }

  function lihat(el, fn, ambang) {
    var o = new IntersectionObserver(function (es) {
      if (es[0].isIntersecting) {
        o.disconnect();
        fn();
      }
    }, { threshold: ambang || 0.3 });
    o.observe(el);
  }

  var warna = ['#F2A65A', '#7FB5E8', '#8CCB93', '#F2D16B', '#B9A4E6'];

  function satuKonfeti(x, y, i) {
    var p = document.createElement('span');
    p.className = 'konfeti';
    p.style.left = x + 'px';
    p.style.top = y + 'px';
    p.style.background = warna[i % warna.length];
    p.style.width = 6 + Math.random() * 6 + 'px';
    p.style.height = 8 + Math.random() * 8 + 'px';
    document.body.appendChild(p);
    var sudut = Math.random() * Math.PI * 2;
    var jarak = 70 + Math.random() * 130;
    var dx = Math.cos(sudut) * jarak;
    var dy = Math.sin(sudut) * jarak - 60;
    var a = p.animate([
      { transform: 'translate(0, 0) rotate(0deg)', opacity: 1 },
      { transform: 'translate(' + dx + 'px, ' + dy + 'px) rotate(' + Math.random() * 540 + 'deg)', opacity: 1, offset: 0.6 },
      { transform: 'translate(' + dx * 1.1 + 'px, ' + (dy + 140) + 'px) rotate(' + Math.random() * 720 + 'deg)', opacity: 0 }
    ], { duration: 1100 + Math.random() * 500, easing: 'cubic-bezier(0.2, 0.7, 0.3, 1)' });
    a.onfinish = function () {
      p.remove();
    };
  }

  function konfeti(x, y, n) {
    if (!halus) return;
    for (var i = 0; i < n; i++) satuKonfeti(x, y, i);
  }

  var mb = $('#mb');
  var mm = $('#mm');

  function tutupMenu() {
    mm.classList.remove('open');
    mb.setAttribute('aria-expanded', 'false');
    mb.textContent = '☰';
  }

  mb.onclick = function () {
    var terbuka = mm.classList.toggle('open');
    mb.setAttribute('aria-expanded', terbuka);
    mb.textContent = terbuka ? '✕' : '☰';
  };

  $$('.mm a').forEach(function (a) {
    a.addEventListener('click', tutupMenu);
  });

  var opts = $$('.opt');
  var fb = $('#fb');
  var pb = $('#pb');
  var nomor = $('.qh span:last-child');
  var dipilih = null;
  var waktu;

  function tulis(teks, kelas) {
    fb.className = 'fb' + (kelas ? ' ' + kelas : '');
    fb.textContent = teks;
    if (halus) {
      void fb.offsetWidth;
      fb.classList.add('ganti');
    }
  }

  function reset() {
    opts.forEach(function (o) {
      o.className = 'opt';
    });
    dipilih = null;
    tulis('Pilih satu jawaban dulu, ya.');
  }

  opts.forEach(function (o) {
    o.onclick = function () {
      opts.forEach(function (x) {
        x.className = 'opt';
      });
      o.classList.add('sel');
      dipilih = o;
      tulis('Siap? Tekan Jawab.');
    };
  });

  $('#jw').onclick = function (e) {
    if (!dipilih) {
      tulis('Pilih satu jawaban dulu, ya.');
      return;
    }
    if (dipilih.dataset.v === '1') {
      dipilih.className = 'opt ok';
      tulis('Hebat! Jawabanmu benar! 🎉', 'ok');
      var r = e.currentTarget.getBoundingClientRect();
      konfeti(r.left + r.width / 2, r.top, 28);
    } else {
      dipilih.className = 'opt no';
      tulis('Hampir benar! Yuk, coba lagi.', 'no');
    }
  };

  $('#nx').onclick = function () {
    reset();
    pb.style.width = '80%';
    nomor.textContent = 'Pertanyaan 5 dari 5';
    clearTimeout(waktu);
    waktu = setTimeout(function () {
      pb.style.width = '60%';
      nomor.textContent = 'Pertanyaan 4 dari 5';
    }, 2000);
  };

  if (!halus) return;

  document.documentElement.classList.add('js');

  var progres = document.createElement('div');
  progres.className = 'progres';
  document.body.appendChild(progres);

  var atas = document.createElement('button');
  atas.className = 'atas';
  atas.setAttribute('aria-label', 'Kembali ke atas');
  atas.textContent = '↑';
  atas.onclick = function () {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  };
  document.body.appendChild(atas);

  var nav = $('nav');

  function gulir() {
    var y = window.scrollY;
    var tinggi = document.documentElement.scrollHeight - window.innerHeight;
    progres.style.transform = 'scaleX(' + (tinggi > 0 ? y / tinggi : 0) + ')';
    nav.classList.toggle('kecil', y > 20);
    atas.classList.toggle('lihat', y > 600);
  }

  window.addEventListener('scroll', gulir, { passive: true });
  gulir();

  var tautan = $$('.links a');
  var peta = {};
  tautan.forEach(function (a) {
    peta[a.getAttribute('href').slice(1)] = a;
  });

  var pengintai = new IntersectionObserver(function (es) {
    es.forEach(function (e) {
      if (e.isIntersecting) {
        tautan.forEach(function (a) {
          a.classList.remove('aktif');
        });
        var a = peta[e.target.id];
        if (a) a.classList.add('aktif');
      }
    });
  }, { rootMargin: '-45% 0px -50% 0px' });

  $$('section[id]').forEach(function (s) {
    pengintai.observe(s);
  });

  var judul = $('.hero h1');
  if (judul) {
    var kata = judul.textContent.trim().split(/\s+/);
    judul.textContent = '';
    kata.forEach(function (k, i) {
      var s = document.createElement('span');
      s.className = 'kata';
      s.style.setProperty('--i', i);
      s.textContent = k;
      judul.appendChild(s);
      if (i < kata.length - 1) judul.appendChild(document.createTextNode(' '));
    });
  }

  var daftar = $$('section:not(.hero) h2, section:not(.hero) .lead, .qz, .fin');
  ['.g4 .card', '.g5 .card', '.steps > .card', '.pg .card', '.stats .card', '.fg > div'].forEach(function (s) {
    $$(s).forEach(function (el, i) {
      el.style.setProperty('--d', i * 90 + 'ms');
      daftar.push(el);
    });
  });

  daftar.forEach(function (el) {
    el.classList.add('rv');
  });

  var pemunculan = new IntersectionObserver(function (es) {
    es.forEach(function (e) {
      if (e.isIntersecting) {
        var el = e.target;
        el.classList.add('tampil');
        pemunculan.unobserve(el);
        setTimeout(function () {
          el.classList.remove('rv');
        }, 1800);
      }
    });
  }, { threshold: 0.15, rootMargin: '0px 0px -6% 0px' });

  daftar.forEach(function (el) {
    pemunculan.observe(el);
  });

  var langkah = $('.steps');
  if (langkah) {
    lihat(langkah, function () {
      langkah.classList.add('mulai');
    }, 0.4);
  }

  function hitung(el, awal, akhir, sisa) {
    var mulai = null;
    function jalan(t) {
      if (!mulai) mulai = t;
      var p = Math.min((t - mulai) / 1400, 1);
      var e = 1 - Math.pow(1 - p, 3);
      el.textContent = awal + Math.round(akhir * e) + sisa;
      if (p < 1) requestAnimationFrame(jalan);
    }
    requestAnimationFrame(jalan);
  }

  $$('.stat').forEach(function (k) {
    var b = $('b', k);
    var u = $('u', k);
    var m = b.textContent.match(/^(\D*)(\d+)(.*)$/);
    var tujuan = u.style.width;
    u.style.width = '0%';
    if (m) b.textContent = m[1] + '0' + m[3];
    lihat(k, function () {
      if (m) hitung(b, m[1], parseInt(m[2], 10), m[3]);
      setTimeout(function () {
        u.style.width = tujuan;
      }, 200);
    }, 0.5);
  });

  var qz = $('.qz');
  if (qz && pb) {
    pb.style.width = '0%';
    lihat(qz, function () {
      setTimeout(function () {
        pb.style.width = '60%';
      }, 300);
    }, 0.4);
  }

  var fin = $('.fin');
  if (fin) {
    ['bt1', 'bt2', 'bt3'].forEach(function (k) {
      var s = document.createElement('span');
      s.className = 'bentuk ' + k;
      s.setAttribute('aria-hidden', 'true');
      fin.insertBefore(s, fin.firstChild);
    });
  }

  document.addEventListener('pointerdown', function (e) {
    var t = e.target.closest('.btn, .opt');
    if (!t) return;
    var r = t.getBoundingClientRect();
    var s = document.createElement('span');
    s.className = 'riak';
    s.style.left = e.clientX - r.left + 'px';
    s.style.top = e.clientY - r.top + 'px';
    t.appendChild(s);
    setTimeout(function () {
      s.remove();
    }, 700);
  });

  var stage = $('.stage');
  var mas = stage ? $('.mascot', stage) : null;

  if (stage && mas) {
    [[12, 20], [84, 16], [92, 66], [7, 72]].forEach(function (p, i) {
      var k = document.createElement('span');
      k.className = 'kilau';
      k.setAttribute('aria-hidden', 'true');
      k.style.left = p[0] + '%';
      k.style.top = p[1] + '%';
      k.style.animationDelay = i * 0.8 + 's';
      stage.appendChild(k);
    });

    var gel = document.createElement('div');
    gel.className = 'gelembung';
    gel.setAttribute('role', 'status');
    stage.appendChild(gel);

    var pesan = ['Halo! Aku Lumo 👋', 'Yuk, belajar bareng!', 'Wah, kamu hebat!', 'Mau belajar apa hari ini?'];
    var urutan = 0;
    var tunggu;

    function sapa() {
      var r = mas.getBoundingClientRect();
      gel.textContent = pesan[urutan++ % pesan.length];
      gel.classList.add('lihat');
      mas.classList.remove('lompat');
      void mas.offsetWidth;
      mas.classList.add('lompat');
      konfeti(r.left + r.width / 2, r.top + r.height / 3, 16);
      clearTimeout(tunggu);
      tunggu = setTimeout(function () {
        gel.classList.remove('lihat');
      }, 2400);
    }

    mas.setAttribute('tabindex', '0');
    mas.addEventListener('click', sapa);
    mas.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') {
        e.preventDefault();
        sapa();
      }
    });
    mas.addEventListener('animationend', function (e) {
      if (e.animationName === 'lompat') mas.classList.remove('lompat');
    });

    if (kursor) {
      var kartu = $$('.fc', stage);
      var dalam = [26, -22, 18];

      stage.addEventListener('mousemove', function (e) {
        var r = stage.getBoundingClientRect();
        var x = (e.clientX - r.left) / r.width - 0.5;
        var y = (e.clientY - r.top) / r.height - 0.5;
        stage.style.setProperty('--mx', (x + 0.5) * 100 + '%');
        stage.style.setProperty('--my', (y + 0.5) * 100 + '%');
        mas.style.translate = x * 18 + 'px ' + y * 18 + 'px';
        kartu.forEach(function (f, i) {
          f.style.translate = x * dalam[i] + 'px ' + y * dalam[i] + 'px';
        });
      });

      stage.addEventListener('mouseleave', function () {
        mas.style.translate = '';
        kartu.forEach(function (f) {
          f.style.translate = '';
        });
      });
    }
  }

  var semuaMaskot = $$('svg[viewBox="0 0 200 220"]');
  var kx = 0;
  var ky = 0;
  var sibuk = false;

  function ikuti() {
    sibuk = false;
    semuaMaskot.forEach(function (s) {
      var r = s.getBoundingClientRect();
      var dx = Math.max(-1, Math.min(1, (kx - (r.left + r.width / 2)) / 260)) * 4;
      var dy = Math.max(-1, Math.min(1, (ky - (r.top + r.height / 2)) / 260)) * 3;
      $$('rect[width="14"], rect[width="5"]', s).forEach(function (m) {
        m.style.translate = dx + 'px ' + dy + 'px';
      });
    });
  }

  if (kursor) {
    document.addEventListener('mousemove', function (e) {
      kx = e.clientX;
      ky = e.clientY;
      if (!sibuk) {
        sibuk = true;
        requestAnimationFrame(ikuti);
      }
    });

    $$('.card').forEach(function (k) {
      k.classList.add('tilt');
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

    $$('.cta .btn').forEach(function (b) {
      b.addEventListener('mousemove', function (e) {
        var r = b.getBoundingClientRect();
        b.style.translate = (e.clientX - r.left - r.width / 2) * 0.22 + 'px ' + (e.clientY - r.top - r.height / 2) * 0.3 + 'px';
      });
      b.addEventListener('mouseleave', function () {
        b.style.translate = '';
      });
    });
  }

  setInterval(function () {
    var mata = $$('svg rect[width="14"]');
    mata.forEach(function (m) {
      m.classList.add('kedip');
    });
    setTimeout(function () {
      mata.forEach(function (m) {
        m.classList.remove('kedip');
      });
    }, 150);
  }, 3800);
})();