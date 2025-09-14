document.addEventListener("DOMContentLoaded", function () {
    // =========================
    // Update Tanggal & Waktu
    // =========================
    const hari = [
        "Minggu",
        "Senin",
        "Selasa",
        "Rabu",
        "Kamis",
        "Jumat",
        "Sabtu",
    ];
    const bulan = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    function updateTanggalWaktu() {
        const now = new Date();
        const namaHari = hari[now.getDay()];
        const tanggal = now.getDate().toString().padStart(2, "0");
        const namaBulan = bulan[now.getMonth()];
        const tahun = now.getFullYear();
        const jam = now.getHours().toString().padStart(2, "0");
        const menit = now.getMinutes().toString().padStart(2, "0");
        const detik = now.getSeconds().toString().padStart(2, "0");

        const elem = document.getElementById("tanggalWaktu");
        if (elem) {
            elem.textContent = `${namaHari}, ${tanggal} ${namaBulan} ${tahun} ${jam}:${menit}:${detik}`;
        }
    }

    updateTanggalWaktu();
    setInterval(updateTanggalWaktu, 1000);

    // =========================
    // Cek Hari Presensi
        // =========================
        function cekHariIni() {
            const hariIni = new Date().getDay(); // 0=Minggu, 6=Sabtu
            if (hariIni === 0 || hariIni === 6) {
                Swal.fire({
                    icon: "error",
                    title: "Tidak Dapat Presensi",
                    text: "Presensi tidak diizinkan pada hari Sabtu dan Minggu.",
                });
                return false;
            }
            return true;
        }

    // =========================
    // Presensi Datang
    // =========================
    window.presensiMasuk = function () {
        if (!cekHariIni()) return;

        fetch(window.presensiUrl.masuk, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": window.presensiUrl.csrf,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ siswa_id: window.presensiUrl.siswaId }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire("Berhasil!", data.success, "success");
                } else {
                    Swal.fire("Oops...", data.error, "error");
                }
            })
            .catch(() => {
                Swal.fire("Oops...", "Terjadi kesalahan!", "error");
            });
    };

    // =========================
    // Presensi Pulang
    // =========================
    window.presensiKeluar = function () {
        if (!cekHariIni()) return;

        fetch(window.presensiUrl.keluar, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": window.presensiUrl.csrf,
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ siswa_id: window.presensiUrl.siswaId }),
        })
            .then((res) => res.json())
            .then((data) => {
                if (data.success) {
                    Swal.fire("Berhasil!", data.success, "success");
                } else {
                    Swal.fire("Oops...", data.error, "error");
                }
            })
            .catch(() => {
                Swal.fire("Oops...", "Terjadi kesalahan!", "error");
            });
    };
});
