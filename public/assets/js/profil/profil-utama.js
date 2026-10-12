
(function () {
  "use strict";

  var NS = "http://www.w3.org/2000/svg";
  var reduce = false;

  try {
    reduce = window.matchMedia(
      "(prefers-reduced-motion: reduce)"
    ).matches;
  } catch (e) {}

  function sapaan() {
    var el = document.querySelector("[data-sapaan]");
    if (!el) return;

    var jam = new Date().getHours();
    var waktu =
      jam < 11 ? "pagi" :
      jam < 15 ? "siang" :
      jam < 18 ? "sore" : "malam";

    var nama = el.getAttribute("data-nama");

    el.textContent =
      "Selamat " + waktu + (nama ? ", " + nama : "") + "!";
  }

  function hitung() {
    document.querySelectorAll("[data-hitung]").forEach(function (el) {
      if (el.dataset.animasiSelesai === "true") return;

      var target = parseInt(el.getAttribute("data-hitung"), 10);

      if (!Number.isFinite(target)) target = 0;

      target = Math.max(0, target);

      if (reduce || target === 0) {
        el.textContent = target;
        el.dataset.animasiSelesai = "true";
        return;
      }

      var mulai = null;
      var durasi = 1000;

      function langkah(waktu) {
        if (mulai === null) mulai = waktu;

        var progres = Math.min((waktu - mulai) / durasi, 1);
        var halus = 1 - Math.pow(1 - progres, 4);

        el.textContent = Math.round(target * halus);

        if (progres < 1) {
          requestAnimationFrame(langkah);
        } else {
          el.textContent = target;
          el.dataset.animasiSelesai = "true";
        }
      }

      requestAnimationFrame(langkah);
    });
  }

  function buat(nama, atribut, induk) {
    var el = document.createElementNS(NS, nama);

    Object.keys(atribut).forEach(function (k) {
      el.setAttribute(k, atribut[k]);
    });

    if (induk) induk.appendChild(el);

    return el;
  }

  function grafik() {
    var svg = document.getElementById("pu-grafik");
    if (!svg || svg.dataset.grafikDibuat === "true") return;

    var data;

    try {
      data = JSON.parse(svg.getAttribute("data-aktivitas") || "[]");
    } catch (e) {
      return;
    }

    if (!Array.isArray(data) || data.length < 2) return;

    data = data.map(function (item) {
      return {
        nilai: Number(item.nilai),
        label: String(item.label == null ? "" : item.label)
      };
    });

    if (!data.every(function (item) {
      return Number.isFinite(item.nilai) && item.nilai >= 0;
    })) {
      return;
    }

    var W = 640;
    var H = 300;
    var L = 42;
    var R = 24;
    var T = 36;
    var B = 42;

    var maks = Math.max.apply(
      null,
      data.map(function (item) {
        return item.nilai;
      }).concat([4])
    );

    var langkah = Math.max(1, Math.ceil(maks / 4));
    var atas = langkah * 4;

    var x = function (i) {
      return L + ((W - L - R) * i) / (data.length - 1);
    };

    var y = function (nilai) {
      return T + (H - T - B) * (1 - nilai / atas);
    };

    svg.replaceChildren();
    svg.setAttribute("viewBox", "0 0 " + W + " " + H);
    svg.setAttribute("preserveAspectRatio", "xMidYMid meet");
    svg.setAttribute("role", "img");
    svg.setAttribute("aria-label", "Grafik aktivitas belajar selama tujuh hari");

    var defs = buat("defs", {}, svg);

    var gradien = buat("linearGradient", {
      id: "pu-isi",
      x1: "0",
      y1: "0",
      x2: "0",
      y2: "1"
    }, defs);

    buat("stop", {
      offset: "0%",
      "stop-color": "#C85F1B",
      "stop-opacity": "0.26"
    }, gradien);

    buat("stop", {
      offset: "100%",
      "stop-color": "#C85F1B",
      "stop-opacity": "0"
    }, gradien);

    for (var i = 0; i <= 4; i++) {
      var nilaiSumbu = langkah * i;
      var posisiY = y(nilaiSumbu);

      buat("line", {
        x1: L,
        x2: W - R,
        y1: posisiY,
        y2: posisiY,
        class: "pu-garis"
      }, svg);

      var labelSumbu = buat("text", {
        x: L - 10,
        y: posisiY + 4,
        "text-anchor": "end",
        class: "pu-sumbu"
      }, svg);

      labelSumbu.textContent = nilaiSumbu;
    }

    var titik = data.map(function (item, indeks) {
      return [x(indeks), y(item.nilai)];
    });

    var jalur = titik.map(function (posisi, indeks) {
      return (indeks === 0 ? "M" : "L") +
        posisi[0] + " " + posisi[1];
    }).join(" ");

    buat("path", {
      d: jalur +
        " L " + x(data.length - 1) + " " + y(0) +
        " L " + x(0) + " " + y(0) + " Z",
      fill: "url(#pu-isi)",
      class: "pu-area"
    }, svg);

    buat("path", {
      d: jalur,
      pathLength: "1",
      class: "pu-jalur"
    }, svg);

    data.forEach(function (item, indeks) {
      var posisi = titik[indeks];
      var terakhir = indeks === data.length - 1;
      var tunda = (0.3 + indeks * 0.08) + "s";

      var lingkaran = buat("circle", {
        cx: posisi[0],
        cy: posisi[1],
        r: terakhir ? 7 : 5,
        class: "pu-titik" + (terakhir ? " is-akhir" : "")
      }, svg);

      var labelNilai = buat("text", {
        x: posisi[0],
        y: posisi[1] - 13,
        "text-anchor": "middle",
        class: "pu-nilai"
      }, svg);

      var labelTanggal = buat("text", {
        x: posisi[0],
        y: H - 14,
        "text-anchor": "middle",
        class: "pu-tanggal"
      }, svg);

      labelNilai.textContent = item.nilai;
      labelTanggal.textContent = item.label;

      if (!reduce) {
        lingkaran.style.animationDelay = tunda;
        labelNilai.style.animationDelay = tunda;
        labelTanggal.style.animationDelay =
          (0.2 + indeks * 0.06) + "s";
      }
    });

    svg.dataset.grafikDibuat = "true";

    if (!reduce) {
      requestAnimationFrame(function () {
        svg.classList.add("is-hidup");
      });
    } else {
      svg.classList.add("is-hidup");
    }
  }

  function mulai() {
    sapaan();
    hitung();
    grafik();
  }

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", mulai, { once: true });
  } else {
    mulai();
  }
})();