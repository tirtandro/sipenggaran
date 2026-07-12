# SIPENGGARAN - Sistem Pencatatan Pelanggaran Murid

SIPENGGARAN adalah sistem informasi manajemen pencatatan pelanggaran murid berbasis web yang dikembangkan khusus untuk **SMA Negeri 2 Wates** berdasarkan peraturan Tata Tertib dan Norma Berkehidupan Sosial Sekolah Tahun Ajaran 2025/2026 & 2026/2027.

Sistem ini membantu mempermudah Guru BK, Guru Piket, Wali Kelas, dan Administrator dalam mencatat, memantau, mengarsip, serta menerbitkan surat peringatan secara otomatis dan terstruktur.

---

## 🚀 Fitur Utama

1. **Sistem Poin Kumulatif & Eskalasi Otomatis:**
   - Kalkulasi poin pelanggaran murid secara real-time pada tahun ajaran aktif.
   - Klasifikasi status poin: **Normal (Hijau: 0-30)**, **Peringatan (Kuning: 31-60)**, **Pembinaan Khusus (Oranye: 61-100)**, dan **Kritis (Merah: >100)**.
2. **Multi-Role & Hak Akses:**
   - **Admin:** Kontrol penuh sistem, manajemen user, murid, tahun ajaran, dan referensi tata tertib.
   - **Guru BK:** Mencatat pelanggaran semua murid, mengelola tindakan sanksi, dan menerbitkan surat peringatan (SP).
   - **Guru Piket:** Mencatat pelanggaran harian siswa.
   - **Wali Kelas:** Memantau siswa di kelasnya serta mengunduh surat peringatan terkait kelasnya.
3. **Cetak Surat Peringatan (SP1, SP2, SP3) ke PDF:**
   - Dilengkapi fitur kustomisasi nama kepala sekolah, NIP, dan tanggal cetak secara dinamis sebelum PDF digenerate.
4. **Import Murid Massal via Excel:**
   - Template Excel interaktif dengan dropdown list validasi Jenis Kelamin dan daftar Kelas aktif dari database.
5. **Manajemen Tahun Ajaran & Arsip:**
   - Mengaktifkan tahun ajaran berjalan (misalnya `2026/2027`) dan mengarsipkan data tahun ajaran sebelumnya secara otomatis.
   - Menyalin struktur kelas dari tahun ajaran sebelumnya ke tahun ajaran baru.
6. **Manajemen Referensi Tata Tertib:**
   - Admin dapat menambah, merubah (kode, deskripsi, tingkat, poin), dan menghapus referensi tata tertib secara dinamis.
7. **Laporan & Ekspor:**
   - Export rekap laporan pelanggaran per kelas atau per bulan ke format **Excel** dan **PDF Landscape**.

---

## 🛠️ Tech Stack

- **Backend:** Laravel 12 (PHP 8.2+)
- **Frontend:** Blade Templates, Tailwind CSS (via CDN), Alpine.js, Chart.js
- **Database:** SQLite
- **Libraries:**
  - `barryvdh/laravel-dompdf` (Ekspor PDF)
  - `maatwebsite/excel` (Ekspor/Import Excel)

---

## 💻 Instalasi dan Penggunaan

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi secara lokal:

1. **Clone repository:**
   ```bash
   git clone https://github.com/tirtandro/sipenggaran.git
   cd sipenggaran
   ```

2. **Install dependensi PHP:**
   ```bash
   composer install
   ```

3. **Salin file konfigurasi env:**
   ```bash
   copy .env.example .env
   ```

4. **Generate application key:**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi database dan seeding data default:**
   ```bash
   php artisan migrate:fresh --seed
   ```
   *Perintah ini akan membuat file SQLite secara otomatis, melakukan migrasi skema tabel, dan memasukkan data seeder (Tata tertib Pasal 1-8, Akun default, Kelas, dan Murid dummy).*

6. **Jalankan server lokal:**
   ```bash
   php artisan serve
   ```
   Akses aplikasi di browser melalui alamat: `http://127.0.0.1:8000`

---

## 🔑 Akun Default untuk Login

Gunakan kredensial berikut untuk masuk ke sistem setelah proses seeding:

| Role | Email | Password |
|---|---|---|
| **Admin** | `admin@sman2wates.sch.id` | `password` |
| **Guru BK** | `gurubk@sman2wates.sch.id` | `password` |
| **Guru Piket** | `gurupiket@sman2wates.sch.id` | `password` |
| **Wali Kelas (X A)** | `walikelas@sman2wates.sch.id` | `password` |
