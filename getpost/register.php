<?php
session_start();

$errors      = [];
$regSuccess  = false;
$dataSuccess = [];

// Jika sudah login, tidak perlu register lagi
if (isset($_SESSION['user_email'])) {
    header('Location: dashboard.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username         = trim($_POST['username'] ?? '');
    $email            = trim($_POST['email'] ?? '');
    $password_new     = $_POST['password-new'] ?? '';
    $password_confirm = $_POST['password-confirm'] ?? '';
    $gender           = $_POST['gender'] ?? '';
    $anonymous        = isset($_POST['anonymous']) ? 1 : 0;

    if (empty($username))
        $errors['username'] = 'Username tidak boleh kosong.';
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL))
        $errors['email'] = 'Email tidak valid.';
    if (strlen($password_new) < 6)
        $errors['password'] = 'Password minimal 6 karakter.';
    if ($password_new !== $password_confirm)
        $errors['confirm'] = 'Password tidak cocok.';
    if (empty($gender))
        $errors['gender'] = 'Jenis kelamin harus dipilih.';

    if (empty($errors)) {
        // Registrasi berhasil — tampilkan halaman sukses di file yang sama
        $regSuccess  = true;
        $dataSuccess = [
            'username' => $username,
            'email'    => $email,
            'gender'   => $gender === 'L' ? 'Laki-Laki' : 'Perempuan',
        ];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SiMADIK REGISTER</title>
    <link rel="stylesheet" href="register-style.css">
    <style>
        /* Halaman Registrasi Sukses */
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .success-box {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        .success-icon {
            width: 72px;
            height: 72px;
            background: #22c55e;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: #fff;
        }
        .success-box h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }
        .success-box p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 24px;
        }
        .info-table {
            background: #f7fafc;
            border-radius: 10px;
            padding: 16px 20px;
            text-align: left;
            margin-bottom: 28px;
        }
        .info-row {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            padding: 6px 0;
            border-bottom: 1px solid #e2e8f0;
        }
        .info-row:last-child { border-bottom: none; }
        .info-label { color: #718096; }
        .info-value { color: #1a202c; font-weight: 600; }
        .btn-login {
            display: block;
            width: 100%;
            padding: 13px;
            background: #22c55e;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
            box-sizing: border-box;
        }
        .btn-login:hover { background: #16a34a; }
    </style>
</head>
<body>

<?php if ($regSuccess): ?>
<!-- =============================================
     TAMPILAN REGISTRASI BERHASIL
============================================= -->
    <div class="success-container">
        <div class="success-box">
            <div class="success-icon">✓</div>
            <h2>Registrasi Berhasil!</h2>
            <p>Akun Anda telah berhasil dibuat. Silakan login untuk melanjutkan.</p>

            <div class="info-table">
                <div class="info-row">
                    <span class="info-label">Username</span>
                    <span class="info-value"><?php echo htmlspecialchars($dataSuccess['username']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value"><?php echo htmlspecialchars($dataSuccess['email']); ?></span>
                </div>
                <div class="info-row">
                    <span class="info-label">Jenis Kelamin</span>
                    <span class="info-value"><?php echo htmlspecialchars($dataSuccess['gender']); ?></span>
                </div>
            </div>

            <a href="index.php?registered=1" class="btn-login">Login Sekarang →</a>
        </div>
    </div>

<?php else: ?>
<!-- =============================================
     TAMPILAN FORM REGISTER
============================================= -->
    <a href="index.php" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 0L6.59 1.41L12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/>
        </svg>
        Back to site
    </a>

    <div class="container">
        <div class="form-container">
            <h2>REGISTER</h2>

            <?php if (!empty($errors)): ?>
                <div class="alert alert-error">
                    Mohon perbaiki kesalahan di bawah ini.
                </div>
            <?php endif; ?>

            <form id="registerForm" action="register.php" method="POST">

                <div class="form-group <?php echo isset($errors['username']) ? 'has-error' : ''; ?>" id="usernameGroup">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Username"
                        autocomplete="username"
                        value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
                    <?php if (isset($errors['username'])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($errors['username']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo isset($errors['email']) ? 'has-error' : ''; ?>" id="emailGroup">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email"
                        autocomplete="email"
                        value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                    <?php if (isset($errors['email'])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($errors['email']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo isset($errors['password']) ? 'has-error' : ''; ?>" id="passwordGroup">
                    <label for="password-new">Password Baru</label>
                    <input type="password" id="password-new" name="password-new" placeholder="Password" autocomplete="new-password">
                    <div class="password-strength">
                        <div class="strength-bar">
                            <div class="strength-bar-fill" id="strengthBarFill"></div>
                        </div>
                        <span class="strength-text" id="strengthText"></span>
                    </div>
                    <?php if (isset($errors['password'])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($errors['password']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="form-group <?php echo isset($errors['confirm']) ? 'has-error' : ''; ?>" id="confirmGroup">
                    <label for="password-confirm">Konfirmasi Password</label>
                    <input type="password" id="password-confirm" name="password-confirm" placeholder="Password" autocomplete="new-password">
                    <?php if (isset($errors['confirm'])): ?>
                        <span class="error-message"><?php echo htmlspecialchars($errors['confirm']); ?></span>
                    <?php endif; ?>
                </div>

                <input type="hidden" id="gender" name="gender" value="<?php echo htmlspecialchars($_POST['gender'] ?? ''); ?>">
                <div class="btn-group <?php echo isset($errors['gender']) ? 'has-error' : ''; ?>">
                    <button type="button" class="btn btn-secondary <?php echo (($_POST['gender'] ?? '') === 'L') ? 'active' : ''; ?>" id="btnMale">Laki-Laki</button>
                    <button type="button" class="btn btn-secondary <?php echo (($_POST['gender'] ?? '') === 'P') ? 'active' : ''; ?>" id="btnFemale">Perempuan</button>
                    <?php if (isset($errors['gender'])): ?>
                        <span class="error-message" style="display:block;"><?php echo htmlspecialchars($errors['gender']); ?></span>
                    <?php endif; ?>
                </div>

                <div class="checkbox-container">
                    <input type="checkbox" id="anonymous" name="anonymous"
                        <?php echo isset($_POST['anonymous']) ? 'checked' : ''; ?>>
                    <label for="anonymous" class="checkbox-label">
                        <strong>Daftar sebagai Anonim</strong>
                        <span class="checkbox-description">Email Anda akan disembunyikan dari pengguna lain dan hanya dapat dilihat oleh Admin untuk keperluan keamanan dan verifikasi akun.</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary">REGISTER</button>
                <p style="text-align:center; margin-top:12px;">Sudah punya akun? <a href="index.php">Login di sini.</a></p>

            </form>
        </div>
    </div>

    <script src="register.js"></script>
<?php endif; ?>

</body>
</html>