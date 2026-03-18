const usernameInput = document.getElementById('username');
const emailInput = document.getElementById('email');
const passwordInput = document.getElementById('password-new');
const confirmInput = document.getElementById('password-confirm');
const btnMale = document.getElementById('btnMale');
const btnFemale = document.getElementById('btnFemale');
const genderInput = document.getElementById('gender');

// =============================================
// GENDER SELECTION
// =============================================
btnMale.addEventListener('click', function () {
    btnMale.classList.add('active');
    btnFemale.classList.remove('active');
    genderInput.value = 'L';
});

btnFemale.addEventListener('click', function () {
    btnFemale.classList.add('active');
    btnMale.classList.remove('active');
    genderInput.value = 'P';
});

// =============================================
// PASSWORD STRENGTH CHECKER
// =============================================
passwordInput.addEventListener('input', function () {
    const password = this.value;
    const strengthContainer = document.querySelector('.password-strength');
    const strengthBarFill = document.getElementById('strengthBarFill');
    const strengthText = document.getElementById('strengthText');

    if (password.length === 0) {
        strengthContainer.classList.remove('show');
        return;
    }

    strengthContainer.classList.add('show');

    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.length >= 10) strength++;
    if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
    if (/\d/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;

    strengthBarFill.className = 'strength-bar-fill';
    let strengthLabel = '';
    if (strength <= 2) {
        strengthBarFill.classList.add('weak');
        strengthLabel = 'Lemah';
    } else if (strength <= 4) {
        strengthBarFill.classList.add('medium');
        strengthLabel = 'Sedang';
    } else {
        strengthBarFill.classList.add('strong');
        strengthLabel = 'Kuat';
    }

    strengthText.textContent = 'Kekuatan Password: ' + strengthLabel;
});

// =============================================
// REAL-TIME VALIDATION (UI only)
// =============================================
confirmInput.addEventListener('input', function () {
    const confirmGroup = document.getElementById('confirmGroup');
    if (this.value.length > 0 && passwordInput.value !== this.value) {
        confirmGroup.classList.add('has-error');
    } else {
        confirmGroup.classList.remove('has-error');
    }
});

confirmInput.addEventListener('paste', function (e) {
    e.preventDefault();
    alert('Copy-paste tidak diizinkan untuk konfirmasi password.');
});