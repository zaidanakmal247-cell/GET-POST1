<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['user_email'])) {
    header('Location: dashboard.php');
    exit;
}

$error      = '';
$loginGagal = false;
$emailGagal = '';

// =============================================
// AKUN DEMO (tanpa database)
// =============================================
$demoAccounts = [
    ['email' => 'user@demo.com',     'password' => 'user123'],
    ['email' => 'siswa@demo.com',    'password' => 'siswa123'],
    ['email' => 'orangtua@demo.com', 'password' => 'ortu123'],
    ['email' => 'admin@simadik.id',  'password' => 'admin123'],
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        $error = "Email dan password harus diisi.";
    } else {
        $found = false;
        foreach ($demoAccounts as $acc) {
            if ($acc['email'] === $email && $acc['password'] === $password) {
                $found = true;
                break;
            }
        }

        if ($found) {
            $_SESSION['user_email'] = $email;
            header('Location: dashboard.php');
            exit;
        } else {
            // Tampilkan halaman gagal di file yang sama
            $loginGagal = true;
            $emailGagal = $email;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SIMADIK</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Halaman Login Gagal */
        .failed-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .failed-box {
            background: #fff;
            border-radius: 16px;
            padding: 48px 40px;
            max-width: 420px;
            width: 100%;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        }
        .failed-icon {
            width: 72px;
            height: 72px;
            background: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 36px;
            color: #fff;
        }
        .failed-box h2 {
            font-size: 22px;
            font-weight: 700;
            color: #1a202c;
            margin-bottom: 8px;
        }
        .failed-box p {
            color: #718096;
            font-size: 14px;
            margin-bottom: 20px;
            line-height: 1.6;
        }
        .error-detail {
            background: #fef2f2;
            border: 1px solid #fecaca;
            border-radius: 10px;
            padding: 14px 18px;
            font-size: 13px;
            color: #b91c1c;
            margin-bottom: 24px;
            text-align: left;
        }
        .btn-row {
            display: flex;
            gap: 12px;
        }
        .btn-coba {
            flex: 1;
            padding: 13px;
            background: #3b82f6;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: block;
            transition: background 0.2s;
        }
        .btn-coba:hover { background: #2563eb; }
        .btn-daftar {
            flex: 1;
            padding: 13px;
            background: #f1f5f9;
            color: #475569;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            display: block;
            transition: background 0.2s;
        }
        .btn-daftar:hover { background: #e2e8f0; }
    </style>
</head>
<body>

<?php if ($loginGagal): ?>
<!-- =============================================
     TAMPILAN LOGIN GAGAL
============================================= -->
    <div class="failed-container">
        <div class="failed-box">
            <div class="failed-icon">✕</div>
            <h2>Login Gagal</h2>
            <p>Email atau password yang Anda masukkan tidak sesuai. Pastikan data yang dimasukkan sudah benar.</p>
            <div class="error-detail">
                ❌ Email atau password salah. Silakan periksa kembali dan coba lagi.
            </div>
            <div class="btn-row">
                <a href="index.php?email=<?php echo urlencode($emailGagal); ?>" class="btn-coba">Coba Lagi</a>
                <a href="register.php" class="btn-daftar">Daftar Akun</a>
            </div>
        </div>
    </div>

<?php else: ?>
<!-- =============================================
     TAMPILAN FORM LOGIN
============================================= -->
    <a href="dashboard.php" class="back-btn">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 0L6.59 1.41L12.17 7H0v2h12.17l-5.58 5.59L8 16l8-8z" transform="rotate(180 8 8)"/>
        </svg>
        Back to site
    </a>

    <div class="container">
        <div class="logo">
            <img src="Logo SIMADIK.png" alt="logo simadik">
            <p class="tagline">SMART GOVERNANCE</p>
            <p class="subtitle">LAYANAN PENGADUAN PENDIDIKAN KOTA BENGKULU</p>
        </div>

        <div class="form-container">
            <h2>LOGIN</h2>

            <?php if (isset($_GET['registered']) && $_GET['registered'] == 1): ?>
                <div class="alert alert-success" style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;padding:10px 14px;border-radius:6px;margin-bottom:14px;">
                    ✅ Registrasi berhasil! Silakan login.
                </div>
            <?php endif; ?>

            <?php if (!empty($error)): ?>
                <div class="alert alert-error" style="background:#f8d7da;color:#721c24;border:1px solid #f5c6cb;padding:10px 14px;border-radius:6px;margin-bottom:14px;">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <form id="loginForm" action="index.php" method="POST">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email"
                        value="<?php echo htmlspecialchars($_GET['email'] ?? $_POST['email'] ?? ''); ?>" required>
                </div>
                <div class="form-group">
                    <label for="password">
                        Password
                        <a href="forgotpassword.html" class="forgot-link">(Forgot it?)</a>
                    </label>
                    <input type="password" id="password" name="password" placeholder="Password" required>
                </div>

                <button type="submit" class="btn btn-primary">Log In</button>

                <div class="signup-box">
                    Don't have an account? <a href="register.php">Sign up.</a>
                </div>
            </form>

            <div style="margin-top:20px;padding:12px;background:rgba(255,255,255,0.08);border-radius:8px;font-size:12px;color:#aaa;text-align:left;">
                <strong style="color:#ccc;">📌 Akun Demo:</strong><br><br>
                user@demo.com / user123<br>
                siswa@demo.com / siswa123<br>
                orangtua@demo.com / ortu123<br>
                admin@simadik.id / admin123
            </div>
        </div>
    </div>

    <script src="login.js"></script>
<?php endif; ?>

</body>
</html>