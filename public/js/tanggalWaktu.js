document.addEventListener("DOMContentLoaded", function () {
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

    // Jalankan pertama kali
    updateTanggalWaktu();

    // Update setiap 1 detik
    setInterval(updateTanggalWaktu, 1000);
});
