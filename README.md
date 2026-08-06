# Operasional JMTO

Aplikasi internal untuk operasional jalan tol: penerbitan & pengelolaan kartu tol (kartu dinas/operasional/mitra) berbasis RFID, manajemen tarif (open/exit), durasi tempuh antar-gerbang, dan data petugas gerbang.

Kalau kamu baru pertama kali pegang project ini, baca dulu bagian **[Istilah yang Perlu Diketahui](#istilah-yang-perlu-diketahui)** — banyak nama variabel/tabel di kode memakai istilah operasional jalan tol yang mungkin belum familiar buat developer baru.

## Daftar Isi

- [Tentang Aplikasi](#tentang-aplikasi)
- [Istilah yang Perlu Diketahui](#istilah-yang-perlu-diketahui)
- [Teknologi yang Dipakai](#teknologi-yang-dipakai)
- [Persyaratan](#persyaratan)
- [Instalasi & Menjalankan di Lokal](#instalasi--menjalankan-di-lokal)
- [Konfigurasi Ruas (`RUAS_ID` / `RUAS_NAME`)](#konfigurasi-ruas-ruas_id--ruas_name)
- [Deploy ke Ruas Baru](#deploy-ke-ruas-baru)
- [Struktur Folder Penting](#struktur-folder-penting)
- [Dokumentasi Lengkap](#dokumentasi-lengkap)
- [Changelog](#changelog)

## Tentang Aplikasi

Aplikasi ini **selalu di-deploy satu instance per ruas jalan tol** (misal: satu instance khusus untuk ruas JMJ, satu lagi khusus untuk ruas JPB, dst). Setiap instance hanya menampilkan dan mengelola data milik ruasnya sendiri, tapi tetap terhubung ke satu database integrasi nasional untuk urusan kartu tol.

Kalau kamu diminta "deploy ke ruas baru", itu **tidak berarti menulis kode baru** — cukup atur environment variable dan siapkan database sesuai ruas tujuan. Detailnya ada di bagian [Deploy ke Ruas Baru](#deploy-ke-ruas-baru).

## Istilah yang Perlu Diketahui

| Istilah | Artinya di aplikasi ini |
|---|---|
| **Ruas** | Satu segmen/lintasan jalan tol (misal "JMJ", "JPB"). Satu instance aplikasi = satu ruas. |
| **Gerbang** | Gerbang tol fisik di suatu ruas (tempat kendaraan masuk/keluar tol). Satu ruas punya banyak gerbang. |
| **Tarif Open** | Sistem tarif di mana tarif sudah tetap per golongan kendaraan di satu gerbang (tanpa memperhitungkan gerbang asal). |
| **Tarif Exit** | Sistem tarif di mana tarif dihitung dari pasangan gerbang asal → gerbang keluar (tergantung jarak tempuh). |
| **Golongan (gol1–gol5)** | Klasifikasi kendaraan (golongan I–V) yang punya tarif berbeda-beda. |
| **Kartu Dinas/Operasional/Mitra** | Kartu tol RFID yang diterbitkan untuk keperluan operasional (bukan kartu pelanggan umum), disimpan di `tbl_penerbitan_kartu`. |
| **Blacklist / Whitelist kartu** | Memblokir kartu (misal karena hilang/disalahgunakan) atau membuka blokirnya kembali di semua gerbang tempat kartu itu terdaftar. |
| **NPP** | Nomor Pokok Pegawai — dipakai sebagai username login (kolom `npp_no` di `tbl_pegawai`). |
| **Jabatan** | Posisi/peran pegawai (`tbl_jabatan`). **Penting**: saat ini hanya pegawai dengan `jabatan_id = 1` yang bisa login ke aplikasi ini. |

## Teknologi yang Dipakai

- **Laravel 10** (PHP 8.1+) sebagai backend.
- **Blade** + jQuery, [Select2](https://select2.org/) (dropdown), [DataTables](https://datatables.net/) (tabel data server-side), SweetAlert2 (notifikasi) di sisi frontend.
- **Vite** untuk build aset CSS/JS.
- **Maatwebsite Excel** untuk import data dari file Excel (tarif, petugas).
- **DomPDF** untuk export laporan ke PDF.
- **WebSocket client custom** (`public/assets/js/admin/clientapi.js`) untuk komunikasi dengan alat pembaca kartu RFID (di luar aplikasi Laravel, lihat catatan di bagian Deploy).

## Persyaratan

Sebelum mulai, pastikan sudah terpasang di komputer/servermu:

- **PHP 8.1** atau lebih baru, dengan ekstensi `pdo_mysql` dan `bcmath` aktif (`bcmath` dipakai untuk enkripsi data kartu RFID — tanpa ini fitur kartu akan error).
- **Composer**
- **Node.js** & **npm** (untuk build aset frontend lewat Vite)
- **MySQL** (aplikasi ini butuh sampai 3 koneksi database berbeda, dijelaskan di bagian [Deploy ke Ruas Baru](#deploy-ke-ruas-baru))

## Instalasi & Menjalankan di Lokal

```bash
git clone <url-repo-ini>
cd operasional_jmto

composer install
npm install

cp .env.example .env
php artisan key:generate
```

Lalu buka `.env` dan isi minimal:

- `DB_*` — kredensial database `mysql` (data pusat: ruas, gerbang, pegawai, dst).
- `DB_INTEGRASI_*` — kredensial database `integrasi_bcds` (database integrasi kartu).
- `RUAS_ID` dan `RUAS_NAME` — lihat [Konfigurasi Ruas](#konfigurasi-ruas-ruas_id--ruas_name) di bawah.

> **Catatan untuk kontributor baru**: tabel-tabel yang dipakai aplikasi ini (`tbl_ruas`, `tbl_gerbang`, `tbl_pegawai`, `tbl_penerbitan_kartu`, dst) **bukan dikelola lewat migration Laravel** — itu tabel legacy yang skemanya harus diimpor dari dump SQL. `php artisan migrate` di project ini hanya akan membuat tabel bawaan Laravel (`users`, `jobs`, dst), **bukan** tabel-tabel operasional di atas. Minta dump database ke tim untuk bisa menjalankan aplikasi secara penuh di lokal.

Setelah database siap:

```bash
php artisan migrate   # tabel bawaan Laravel saja
npm run build          # atau `npm run dev` saat development
php artisan serve
```

Buat satu baris di `tbl_pegawai` dengan `jabatan_id = 1` dan `activated = 1` supaya bisa login (lihat penjelasan di tabel istilah di atas).

## Konfigurasi Ruas (`RUAS_ID` / `RUAS_NAME`)

Ruas mana yang dilayani oleh sebuah instance diatur lewat dua environment variable ini (dibaca lewat `config/ruas.php`), **bukan hardcode di kode**:

| Variable | Contoh nilai | Fungsinya |
|---|---|---|
| `RUAS_ID` | `b001` | Kode ruas (kolom `ruas`/`ruas_id` di database) yang datanya ditampilkan/difilter oleh instance ini. |
| `RUAS_NAME` | `JMJ` | Nama/label ruas yang ditampilkan di badge UI (misal di daftar kartu). |

Dua nilai ini dipakai di `Select2CT::getOptionNama()`, `KartuCT::getOptionNama()`, badge ruas di `KartuCT`, dan helper JS `tipeRuas()` pada view `bacaKartu`, `perpanjangKartu`, `whitelist_update`.

## Deploy ke Ruas Baru

Aplikasi ini memakai **3 koneksi database sekaligus** (didefinisikan di `config/database.php`) — penting dipahami sebelum deploy ke ruas baru:

| Koneksi | Isinya | Sifatnya |
|---|---|---|
| `mysql` | Data pusat ruas ini: `tbl_ruas`, `tbl_gerbang` (+ kredensial DB tiap gerbang), `tbl_pegawai`, `tbl_jabatan`, `tbl_log_operasional`. | Satu per instance/ruas. |
| `mysql2` | Data operasional milik **satu gerbang** yang sedang dipilih user (`tbl_pegawai`, `tbl_dasar_tarif`, `tbl_tarif_open`, `tbl_tarif_exit`, `tbl_durasi`, `tbl_blacklist`). | Dinamis — kredensialnya diambil runtime dari baris `tbl_gerbang` di koneksi `mysql`, jadi otomatis "loncat" ke database gerbang yang berbeda-beda. |
| `integrasi_bcds` | Data kartu tingkat nasional: `tbl_penerbitan_kartu`, `tbl_blacklist` master, `tbl_ruas`, `tbl_ktp_*`. | Satu server, **dipakai bersama oleh semua ruas** — jangan buat instance terpisah per ruas. |

Langkah-langkah deploy ke ruas baru:

1. Clone/pull kode ke server ruas baru, jalankan `composer install` dan `npm install && npm run build`.
2. Copy `.env.example` → `.env`, lalu `php artisan key:generate`.
3. Set `RUAS_ID` dan `RUAS_NAME` sesuai ruas tujuan.
4. Siapkan database untuk koneksi `mysql` (`DB_DATABASE`): impor dump SQL yang berisi `tbl_ruas`, `tbl_gerbang`, `tbl_pegawai`, `tbl_jabatan`, `tbl_log_operasional`, `tbl_dasar_tarif`. Pastikan `tbl_ruas` punya baris dengan `ruas_id` yang sama dengan `RUAS_ID` di `.env`.
5. Isi `tbl_gerbang` dengan seluruh gerbang milik ruas ini beserta kredensial DB lokal masing-masing gerbang (`host`, `port`, `database`, `user`, `pass`) — dipakai untuk koneksi `mysql2` yang dinamis. Pastikan setiap DB gerbang tersebut sudah punya tabel `tbl_pegawai`, `tbl_dasar_tarif`, `tbl_tarif_open`, `tbl_tarif_exit`, `tbl_durasi`, `tbl_blacklist`.
6. Set `DB_INTEGRASI_HOST`/`PORT`/`DATABASE`/`USERNAME`/`PASSWORD` ke server `integrasi_bcds` yang sama dipakai semua ruas. Koordinasikan dengan tim pusat agar `RUAS_ID` ruas baru sudah terdaftar di `tbl_ruas` dan gerbang-gerbangnya di `tbl_gerbang` pada database ini (dibutuhkan untuk sinkronisasi blacklist kartu).
7. Set `PUBLIC_KEY`/`PRIVATE_KEY` (kunci RSA enkripsi data kartu RFID) — koordinasikan dengan tim pusat apakah kunci ini shared atau unik per ruas.
8. Jalankan `php artisan migrate` (hanya untuk tabel bawaan Laravel), `php artisan config:cache`, `php artisan storage:link` bila perlu.
9. Buat satu baris `tbl_pegawai` dengan `jabatan_id = 1` dan `activated = 1` — tanpa ini tidak ada yang bisa login (lihat `AuthCT::loginAction`).
10. Siapkan service pembaca kartu RFID lokal (WebSocket `ws://localhost:4949`, lihat `public/assets/js/admin/clientapi.js`) di komputer yang tersambung fisik ke reader kartu. Service ini di luar kode Laravel.
11. Terakhir, uji semuanya: login berhasil, dashboard tampil, dropdown ruas/gerbang menunjukkan data yang benar, dan badge ruas di modul kartu menampilkan `RUAS_NAME` yang sesuai.

## Struktur Folder Penting

Buat yang belum familiar dengan Laravel atau project ini, folder-folder berikut yang paling relevan untuk kerja sehari-hari:

- `app/Http/Controllers/` — logic tiap modul (`KartuCT` untuk kartu RFID, `ManajemenTarifCT`/`DasarTarifCT` untuk tarif, `DurasiCT` untuk durasi, `PetugasCT` untuk petugas, `LogCT` untuk log, `Select2CT` untuk endpoint dropdown).
- `routes/admin/` — daftar route panel admin, dipecah per modul (`kartu/`, `tarif/`, `petugas/`, `durasi/`, `logs/`, `utils/`).
- `resources/views/admin/` — tampilan Blade untuk tiap modul.
- `config/ruas.php` — konfigurasi ruas aktif instance ini (lihat [Konfigurasi Ruas](#konfigurasi-ruas-ruas_id--ruas_name)).
- `config/database.php` — definisi 3 koneksi database (`mysql`, `mysql2`, `integrasi_bcds`).
- `public/assets/js/admin/clientapi.js` — client WebSocket untuk komunikasi dengan alat pembaca kartu RFID.

## Dokumentasi Lengkap

Dokumentasi lebih dalam (PRD, ERD/skema database, arsitektur teknis, dan catatan known issues) ada di Notion — minta link ke tim kalau belum punya akses.

## Changelog

Semua perubahan penting pada aplikasi ini didokumentasikan di sini. Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), dan penomoran versi mengikuti [Semantic Versioning](https://semver.org/).

### [1.1.0] - 2026-08-06

#### Ditambahkan
- Environment variable `RUAS_ID` dan `RUAS_NAME` beserta `config/ruas.php`, sehingga ruas jalan tol yang dilayani oleh sebuah instance diatur lewat `.env`, bukan hardcode di kode.
- Environment variable `APP_VERSION` dan `config('app.version')` untuk melacak versi aplikasi yang di-deploy.

#### Diubah
- `Select2CT::getOptionNama()` dan `KartuCT::getOptionNama()` kini memfilter berdasarkan `config('ruas.id')`, bukan nilai hardcode `'b001'`.
- Render badge ruas di `KartuCT` serta helper JS `tipeRuas()` (view `bacaKartu`, `perpanjangKartu`, `whitelist_update`) kini dibandingkan terhadap `config('ruas.id')`/`config('ruas.name')`, bukan case hardcode `'B001'`/`'JMJ'`.

#### Diperbaiki
- Bug `dd($rows)` di `PetugasImport.php` yang menghentikan proses import Excel petugas setiap kali dijalankan.
