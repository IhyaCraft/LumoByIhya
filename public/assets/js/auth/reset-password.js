(function () {
    'use strict';

    var form = document.querySelector('[data-lrp="form"]');
    if (!form) {
        return;
    }

    var MIN_LENGTH = 8;

    var passwordInput = form.querySelector('[data-lrp="password"]');
    var confirmInput = form.querySelector('[data-lrp="confirm"]');
    var passwordError = form.querySelector('[data-lrp="password-error"]');
    var confirmError = form.querySelector('[data-lrp="confirm-error"]');
    var toggleButton = form.querySelector('[data-lrp="toggle"]');
    var toggleText = form.querySelector('[data-lrp="toggle-text"]');
    var submitButton = form.querySelector('[data-lrp="submit"]');
    var ruleLength = form.querySelector('[data-lrp-rule="length"]');
    var ruleMatch = form.querySelector('[data-lrp-rule="match"]');

    if (!passwordInput || !confirmInput || !submitButton) {
        return;
    }

    var confirmTouched = false;

    function setRule(rule, met) {
        if (!rule) {
            return;
        }
        rule.classList.toggle('is-met', met);
        var status = rule.querySelector('[data-lrp-rule-status]');
        if (status) {
            status.textContent = met ? 'Terpenuhi' : 'Belum terpenuhi';
        }
    }

    function showError(input, output, message) {
        input.classList.add('is-invalid');
        input.setAttribute('aria-invalid', 'true');
        if (output) {
            output.textContent = message;
        }
    }

    function clearError(input, output) {
        input.classList.remove('is-invalid');
        input.removeAttribute('aria-invalid');
        if (output) {
            output.textContent = '';
        }
    }

    function updateRules() {
        var password = passwordInput.value;
        var confirm = confirmInput.value;

        setRule(ruleLength, password.length >= MIN_LENGTH);
        setRule(ruleMatch, confirm.length > 0 && password === confirm);
    }

    function checkMatch() {
        if (!confirmTouched || confirmInput.value === '') {
            clearError(confirmInput, confirmError);
            return;
        }

        if (passwordInput.value !== confirmInput.value) {
            showError(confirmInput, confirmError, 'Kata sandinya belum sama, coba cek lagi ya.');
        } else {
            clearError(confirmInput, confirmError);
        }
    }

    function validate() {
        var password = passwordInput.value;
        var confirm = confirmInput.value;
        var firstInvalid = null;

        if (password === '') {
            showError(passwordInput, passwordError, 'Kata sandi baru belum diisi nih.');
            firstInvalid = passwordInput;
        } else if (password.length < MIN_LENGTH) {
            showError(passwordInput, passwordError, 'Kata sandi minimal ' + MIN_LENGTH + ' karakter ya.');
            firstInvalid = passwordInput;
        } else {
            clearError(passwordInput, passwordError);
        }

        if (confirm === '') {
            showError(confirmInput, confirmError, 'Ketik ulang kata sandimu dulu ya.');
            firstInvalid = firstInvalid || confirmInput;
        } else if (password !== confirm) {
            showError(confirmInput, confirmError, 'Kata sandinya belum sama, coba cek lagi ya.');
            firstInvalid = firstInvalid || confirmInput;
        } else {
            clearError(confirmInput, confirmError);
        }

        return firstInvalid;
    }

    function setVisibility(visible) {
        var type = visible ? 'text' : 'password';
        passwordInput.type = type;
        confirmInput.type = type;

        if (toggleButton) {
            toggleButton.setAttribute('aria-pressed', visible ? 'true' : 'false');
        }
        if (toggleText) {
            toggleText.textContent = visible ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi';
        }
    }

    function resetSubmitState() {
        submitButton.classList.remove('is-loading');
        submitButton.disabled = false;
        submitButton.removeAttribute('aria-busy');
    }

    passwordInput.addEventListener('input', function () {
        updateRules();
        if (passwordInput.classList.contains('is-invalid') && passwordInput.value.length >= MIN_LENGTH) {
            clearError(passwordInput, passwordError);
        }
        checkMatch();
    });

    confirmInput.addEventListener('input', function () {
        confirmTouched = true;
        updateRules();
        checkMatch();
    });

    confirmInput.addEventListener('blur', function () {
        if (confirmInput.value !== '') {
            confirmTouched = true;
            checkMatch();
        }
    });

    if (toggleButton) {
        toggleButton.addEventListener('click', function () {
            setVisibility(toggleButton.getAttribute('aria-pressed') !== 'true');
        });
    }

    form.addEventListener('submit', function (event) {
        confirmTouched = true;
        var firstInvalid = validate();

        if (firstInvalid) {
            event.preventDefault();
            form.classList.remove('is-shaking');
            void form.offsetWidth;
            form.classList.add('is-shaking');
            firstInvalid.focus();
            return;
        }

        submitButton.classList.add('is-loading');
        submitButton.setAttribute('aria-busy', 'true');
        window.setTimeout(function () {
            submitButton.disabled = true;
        }, 0);
    });

    form.addEventListener('animationend', function (event) {
        if (event.target === form) {
            form.classList.remove('is-shaking');
        }
    });

    window.addEventListener('pageshow', function (event) {
        if (event.persisted) {
            resetSubmitState();
        }
    });

    updateRules();
})();