// =============================================
// TAMPILKAN EMAIL USER DARI PHP SESSION
// =============================================
window.addEventListener('DOMContentLoaded', function () {
    // userEmail di-inject dari dashboard.php
    if (typeof userEmail !== 'undefined' && userEmail) {
        // Tampilkan email di navbar
        const navMenu = document.querySelector('.nav-menu');
        if (navMenu) {
            const userItem = document.createElement('li');
            userItem.innerHTML = `<span style="color:#fff;font-size:13px;padding:6px 10px;opacity:0.85;">👤 ${userEmail}</span>`;
            navMenu.insertBefore(userItem, navMenu.lastElementChild);
        }

        // Ganti sapaan di hero
        const heroH1 = document.querySelector('.hero h1');
        if (heroH1) {
            heroH1.textContent = `Selamat Datang di SIMADIK!`;
        }
    }
});

// =============================================
// TRACKING LAPORAN
// =============================================
const trackingBtn = document.getElementById('btnTracking');
if (trackingBtn) {
    trackingBtn.addEventListener('click', function () {
        const kode = document.getElementById('trackingInput').value.trim();

        if (kode === '') {
            alert('Silakan masukkan kode tracking terlebih dahulu.');
            return;
        }

        const dummyReports = {
            'SIM001': { status: 'Sedang Diproses',  category: 'Bullying',   date: '2025-12-20', school: 'SMPN 1 Bengkulu',  description: 'Laporan Anda sedang dalam proses verifikasi oleh admin.' },
            'SIM002': { status: 'Terverifikasi',     category: 'Fasilitas',  date: '2025-12-21', school: 'SMAN 2 Bengkulu',  description: 'Laporan telah diverifikasi dan akan segera ditindaklanjuti.' },
            'SIM003': { status: 'Selesai',           category: 'Pungli',     date: '2025-12-22', school: 'SMKN 3 Bengkulu',  description: 'Laporan telah selesai ditangani. Terima kasih atas laporannya.' },
            'SIM123': { status: 'Sedang Diproses',   category: 'Lainnya',    date: '2025-12-23', school: 'SDN 5 Bengkulu',   description: 'Laporan Anda sedang dalam proses penanganan oleh tim terkait.' }
        };

        const report = dummyReports[kode.toUpperCase()];

        if (report) {
            alert(`📋 DETAIL LAPORAN\n\nKode: ${kode.toUpperCase()}\nStatus: ${report.status}\nKategori: ${report.category}\nSekolah: ${report.school}\nTanggal: ${report.date}\n\nKeterangan:\n${report.description}`);
        } else {
            alert('❌ Kode tracking tidak ditemukan.\n\nContoh kode: SIM001, SIM002, SIM003, SIM123');
        }
    });
}

// =============================================
// NAVBAR SCROLL EFFECT
// =============================================
window.addEventListener('scroll', function () {
    const nav = document.querySelector('.navbar');
    if (nav) {
        nav.style.boxShadow = window.scrollY > 50 ? '0 4px 10px rgba(0,0,0,0.2)' : 'none';
    }
});