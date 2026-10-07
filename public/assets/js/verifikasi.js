(function () {
    var tombol = document.getElementById('tombolKirimUlang');
    var hitungMundur = document.getElementById('hitungMundur');

    if (!tombol || !hitungMundur) {
        return;
    }

    var sisa = parseInt(tombol.dataset.remaining || '0', 10);
    var action = tombol.dataset.action;

    function mulaiCountdown() {
        if (sisa <= 0) {
            tombol.disabled = false;
            hitungMundur.textContent = '';
            return;
        }

        tombol.disabled = true;
        hitungMundur.textContent = '(' + sisa + ' detik)';

        var timer = setInterval(function () {
            sisa--;

            if (sisa <= 0) {
                clearInterval(timer);
                tombol.disabled = false;
                hitungMundur.textContent = '';
                return;
            }

            hitungMundur.textContent = '(' + sisa + ' detik)';
        }, 1000);
    }

    tombol.addEventListener('click', function () {
        if (!action) {
            return;
        }

        tombol.disabled = true;
        tombol.querySelector('span:first-child').textContent = 'Mengirim...';

        var form = document.createElement('form');
        form.method = 'POST';
        form.action = action;

        var csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '<?= csrf_token() ?>';
        csrf.value = '<?= csrf_hash() ?>';

        form.appendChild(csrf);
        document.body.appendChild(form);
        form.submit();
    });

    mulaiCountdown();
})();