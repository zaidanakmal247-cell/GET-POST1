// =============================================
// EMAIL VALIDATION (UI only)
// =============================================
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// =============================================
// LOGIN FORM HANDLER
// =============================================
const loginForm = document.getElementById('loginForm');
if (loginForm) {
    loginForm.addEventListener('submit', function(e) {
        const email    = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;

        // Basic validation — cegah submit jika kosong atau email invalid
        if (!email || !password) {
            e.preventDefault();
            alert('Harap isi semua field!');
            return;
        }

        if (!validateEmail(email)) {
            e.preventDefault();
            alert('Format email tidak valid!');
            return;
        }

        // Jika valid → biarkan form submit ke index.php (PHP yang proses)
    });
}