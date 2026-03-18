<?php
session_start();

// Jika belum login, redirect ke index.php
if (!isset($_SESSION['user_email'])) {
    header('Location: index.php');
    exit;
}

$userEmail = $_SESSION['user_email'];

// Inisialisasi array catatan di session
if (!isset($_SESSION['catatan'])) {
    $_SESSION['catatan'] = [];
}

$successMsg = '';

// =============================================
// PROSES CREATE CATATAN (POST)
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul_catatan'])) {
    $judul = trim($_POST['judul_catatan'] ?? '');
    $isi   = trim($_POST['isi_catatan'] ?? '');

    if (!empty($judul) && !empty($isi)) {
        $_SESSION['catatan'][] = [
            'id'      => uniqid(),
            'judul'   => $judul,
            'isi'     => $isi,
            'penulis' => $userEmail,
            'waktu'   => date('d M Y, H:i'),
        ];
        $successMsg = 'Catatan berhasil disimpan!';
    }
}

$semuaCatatan = array_reverse($_SESSION['catatan']); // terbaru di atas
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>SIMADIK | SmartEdu Report System</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="Styledashboard.css">
  <style>
    /* ── CATATAN SECTION ── */
    .catatan-section {
      max-width: 860px;
      margin: 40px auto;
      padding: 0 20px 60px;
    }

    /* Form tambah catatan */
    .catatan-form-box {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 28px 32px;
      margin-bottom: 36px;
      box-shadow: 0 2px 12px rgba(0,0,0,0.06);
    }
    .catatan-form-box h3 {
      font-size: 16px;
      font-weight: 700;
      color: #1a202c;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }
    .catatan-form-box label {
      display: block;
      font-size: 13px;
      font-weight: 600;
      color: #4a5568;
      margin-bottom: 6px;
    }
    .catatan-form-box input[type="text"],
    .catatan-form-box textarea {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #cbd5e0;
      border-radius: 8px;
      font-size: 14px;
      color: #2d3748;
      background: #f7fafc;
      box-sizing: border-box;
      transition: border 0.2s;
      font-family: inherit;
    }
    .catatan-form-box input[type="text"]:focus,
    .catatan-form-box textarea:focus {
      outline: none;
      border-color: #3b82f6;
      background: #fff;
    }
    .catatan-form-box textarea {
      height: 110px;
      resize: vertical;
    }
    .catatan-form-box .form-group {
      margin-bottom: 16px;
    }
    .btn-simpan {
      background: #3b82f6;
      color: #fff;
      border: none;
      padding: 10px 24px;
      border-radius: 8px;
      font-size: 14px;
      font-weight: 600;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      transition: background 0.2s;
    }
    .btn-simpan:hover { background: #2563eb; }

    /* Alert sukses */
    .alert-success-catatan {
      background: #d1fae5;
      color: #065f46;
      border: 1px solid #6ee7b7;
      border-radius: 8px;
      padding: 10px 16px;
      font-size: 14px;
      margin-bottom: 18px;
      display: flex;
      align-items: center;
      gap: 8px;
    }

    /* Daftar catatan */
    .catatan-list-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 16px;
    }
    .catatan-list-header h3 {
      font-size: 16px;
      font-weight: 700;
      color: #1a202c;
    }
    .badge-count {
      background: #3b82f6;
      color: #fff;
      font-size: 12px;
      font-weight: 600;
      padding: 3px 10px;
      border-radius: 20px;
    }
    .catatan-empty {
      text-align: center;
      color: #a0aec0;
      font-size: 14px;
      padding: 40px 0;
      border: 2px dashed #e2e8f0;
      border-radius: 12px;
    }

    /* Card catatan */
    .catatan-card {
      background: #fff;
      border: 1px solid #e2e8f0;
      border-radius: 12px;
      padding: 20px 24px;
      margin-bottom: 16px;
      box-shadow: 0 1px 6px rgba(0,0,0,0.05);
      position: relative;
    }
    .catatan-card-header {
      display: flex;
      justify-content: space-between;
      align-items: flex-start;
      margin-bottom: 10px;
    }
    .catatan-card-judul {
      font-size: 15px;
      font-weight: 700;
      color: #1a202c;
    }
    .catatan-card-isi {
      font-size: 14px;
      color: #4a5568;
      line-height: 1.6;
      margin-bottom: 12px;
      white-space: pre-wrap;
    }
    .catatan-card-meta {
      font-size: 12px;
      color: #a0aec0;
      display: flex;
      gap: 14px;
    }
    .catatan-card-meta span { display: flex; align-items: center; gap: 4px; }
  </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <div class="nav-container">
    <div class="logo">SIMADIK</div>
    <ul class="nav-menu">
      <li><a href="dashboard.php">Beranda</a></li>
      <li><a href="../halaman-edukasi/edukasi.html">Edukasi</a></li>
      <li><a href="../arsiplaporandan/arsiplaporan.html">Arsip</a></li>
      <li><a href="../TRACKING STATUS/TrackingStatus.html">Tracking</a></li>
      <li><span style="color:#fff;font-size:13px;padding:6px 10px;opacity:0.85;">👤 <?php echo htmlspecialchars($userEmail); ?></span></li>
      <li><a href="logout.php" class="btn-logout">Logout</a></li>
    </ul>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <h1>Selamat Datang, <?php echo htmlspecialchars($userEmail); ?>!</h1>
    <p>Sistem Pelaporan Aduan Pendidikan yang Aman, Cepat, dan Transparan</p>
    <div class="tracking-box">
      <input type="text" id="trackingInput" placeholder="Masukkan kode tracking laporan...">
      <button id="btnTracking">Cari</button>
    </div>
  </div>
</section>

<!-- LAYANAN -->
<section class="section">
  <h2>Layanan Utama SIMADIK</h2>
  <div class="grid-3">
    <a href="../PELAPORAN/formpelaporan.html" class="card">
      <h3>📝 Buat Laporan</h3>
      <p>Laporkan bullying, pungli, pelecehan, atau fasilitas sekolah.</p>
    </a>
    <a href="../livechat/livechat-demo.html" class="card">
      <h3>🕵️ Live Chat</h3>
      <p>Identitas pelapor dijamin aman.</p>
    </a>
    <a href="../TRACKING STATUS/TrackingStatus.html" class="card">
      <h3>📍 Tracking Status</h3>
      <p>Pantau status laporan secara transparan.</p>
    </a>
  </div>
</section>

<!-- PENGGUNA -->
<section class="section white">
  <h2>Pengguna Sistem SIMADIK</h2>
  <div class="grid-4">
    <div class="box">👩‍🎓 <br><strong>Siswa</strong></div>
    <div class="box">👨‍👩‍👧 <br><strong>Orang Tua</strong></div>
    <div class="box">👨‍🏫 <br><strong>Guru</strong></div>
    <div class="box">🏢 <br><strong>Admin Dinas</strong></div>
  </div>
</section>

<!-- KEUNGGULAN -->
<section class="section">
  <h2>Keunggulan SIMADIK</h2>
  <div class="grid-3">
    <div class="card green"><h3>🔐 Keamanan Data</h3><p>Enkripsi, RBAC, audit trail.</p></div>
    <div class="card green"><h3>⚡ Respons Cepat</h3><p>Tindak lanjut cepat dan terstruktur.</p></div>
    <div class="card green"><h3>📊 Transparansi</h3><p>Status laporan dapat dipantau.</p></div>
  </div>
</section>

<!-- =============================================
     FITUR CREATE & READ CATATAN
============================================= -->
<section class="catatan-section">

  <!-- FORM TAMBAH CATATAN (CREATE) -->
  <div class="catatan-form-box">
    <h3>📋 Tambah Catatan Baru</h3>

    <?php if (!empty($successMsg)): ?>
      <div class="alert-success-catatan">
        ✅ <?php echo htmlspecialchars($successMsg); ?>
      </div>
    <?php endif; ?>

    <form method="POST" action="dashboard.php">
      <div class="form-group">
        <label for="judul_catatan">JUDUL CATATAN</label>
        <input type="text" id="judul_catatan" name="judul_catatan"
               placeholder="Contoh: Rangkuman Bab 3 Kimia" required>
      </div>
      <div class="form-group">
        <label for="isi_catatan">ISI CATATAN</label>
        <textarea id="isi_catatan" name="isi_catatan"
                  placeholder="Tulis isi catatan kamu di sini..." required></textarea>
      </div>
      <button type="submit" class="btn-simpan">💾 Simpan Catatan</button>
    </form>
  </div>

  <!-- DAFTAR CATATAN (READ) -->
  <div class="catatan-list-header">
    <h3>📂 Semua Catatan</h3>
    <span class="badge-count"><?php echo count($semuaCatatan); ?> Catatan</span>
  </div>

  <?php if (empty($semuaCatatan)): ?>
    <div class="catatan-empty">
      <p>📭 Belum ada catatan.</p>
      <p>Tambahkan catatan pertamamu di atas!</p>
    </div>
  <?php else: ?>
    <?php foreach ($semuaCatatan as $catatan): ?>
      <div class="catatan-card">
        <div class="catatan-card-header">
          <div class="catatan-card-judul"><?php echo htmlspecialchars($catatan['judul']); ?></div>
        </div>
        <div class="catatan-card-isi"><?php echo htmlspecialchars($catatan['isi']); ?></div>
        <div class="catatan-card-meta">
          <span>👤 <?php echo htmlspecialchars($catatan['penulis']); ?></span>
          <span>🕐 <?php echo htmlspecialchars($catatan['waktu']); ?></span>
        </div>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

</section>

<!-- CTA -->
<section class="cta">
  <h2>Laporkan Masalah Pendidikan Sekarang</h2>
  <p>Aman • Anonim • Transparan</p>
  <a href="../PELAPORAN/formpelaporan.html" class="btn-cta">Buat Laporan</a>
</section>

<!-- FOOTER -->
<footer class="footer">
  © 2025 SIMADIK – SmartEdu Report System <br>
  D4 Sistem Informasi Kota Cerdas – Telkom University
</footer>

<script>const userEmail = "<?php echo addslashes($userEmail); ?>";</script>
<script src="dashboard.js"></script>
</body>
</html>