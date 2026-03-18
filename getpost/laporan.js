const form = document.getElementById("laporanForm");
const successMsg = document.getElementById("successMsg");
const fileInput = document.getElementById("bukti");
const fileInfo = document.getElementById("fileInfo");

// Preview nama file
fileInput.addEventListener("change", function () {
  if (this.files.length > 0) {
    fileInfo.textContent = "File dipilih: " + this.files[0].name;
  } else {
    fileInfo.textContent = "";
  }
});

// Submit form
form.addEventListener("submit", function (e) {
  e.preventDefault();

  const kategori = document.getElementById("kategori").value;
  const kronologi = document.getElementById("kronologi").value;
  const lokasi = document.getElementById("lokasi").value;
  const anonim = document.getElementById("anonim").checked;

  if (kategori === "" || kronologi.trim() === "" || lokasi.trim() === "") {
    alert("❗ Harap lengkapi semua data yang wajib diisi.");
    return;
  }

  const laporan = {
    kategori,
    kronologi,
    lokasi,
    anonim,
    waktu: new Date().toLocaleString()
  };

  console.log("Data Laporan:", laporan);

  successMsg.style.display = "block";
  form.reset();
  fileInfo.textContent = "";

  setTimeout(() => {
    successMsg.style.display = "none";
  }, 4000);
});
