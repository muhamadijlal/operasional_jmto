# Operasional JMTO

Aplikasi operasional untuk pengelolaan kartu tol (kartu dinas/operasional, penerbitan, blacklist/whitelist), manajemen tarif (open/exit), durasi, dan petugas gerbang jalan tol.

Aplikasi ini **di-deploy satu instance per ruas jalan tol**. Ruas mana yang dilayani oleh sebuah instance diatur lewat environment variable, bukan hardcode di kode — lihat `config/ruas.php`.

## Konfigurasi Ruas (`RUAS_ID` / `RUAS_NAME`)

| Variable | Contoh | Keterangan |
|---|---|---|2
| `RUAS_ID` | `b001` | Kode ruas (kolom `ruas`/`ruas_id` di database) yang datanya ditampilkan/difilter oleh instance ini. |
| `RUAS_NAME` | `JMJ` | Label/nama ruas yang ditampilkan di badge UI (daftar kartu, dsb). |

Dipakai di `Select2CT::getOptionNama()`, `KartuCT::getOptionNama()`, badge ruas di `KartuCT`, dan helper JS `tipeRuas()` pada view `bacaKartu`, `perpanjangKartu`, `whitelist_update`.

## Deploy ke Ruas Baru

Aplikasi ini memakai 3 koneksi database (lihat `config/database.php`):

- **`mysql`** — DB pusat instance ruas ini: `tbl_ruas`, `tbl_gerbang` (termasuk kredensial DB tiap gerbang), `tbl_pegawai`, `tbl_jabatan`, `tbl_log_operasional`.
- **`mysql2`** — koneksi dinamis, di-set runtime dari kredensial `tbl_gerbang` (di DB `mysql`) sesuai gerbang yang aktif dipilih user. Ini adalah DB lokal milik gerbang tersebut (`tbl_pegawai`, `tbl_dasar_tarif`, `tbl_tarif_open`, `tbl_tarif_exit`, `tbl_durasi`, `tbl_blacklist`).
- **`integrasi_bcds`** — DB integrasi pusat/nasional (`tbl_penerbitan_kartu`, `tbl_blacklist` master, `tbl_ruas`, `tbl_ktp_*`) yang dipakai bersama oleh semua ruas.

**Catatan penting**: tabel-tabel di atas adalah tabel legacy/eksternal, **tidak ada migration Laravel untuk skema ini** (`database/migrations` hanya berisi tabel default Laravel seperti `users`/`jobs`). Deploy ke ruas baru berarti mengimpor dump SQL skema+data tersebut, bukan sekadar `php artisan migrate`.

Langkah-langkah:

1. Clone/pull kode ke server ruas baru, `composer install`, `npm install && npm run build` (jika ada aset front-end yang di-build).
2. Copy `.env.example` → `.env`, lalu `php artisan key:generate`.
3. Set `RUAS_ID` dan `RUAS_NAME` sesuai ruas tujuan.
4. Siapkan database `DB_DATABASE` (koneksi `mysql`) untuk ruas ini: import dump skema `tbl_ruas`, `tbl_gerbang`, `tbl_pegawai`, `tbl_jabatan`, `tbl_log_operasional`, `tbl_dasar_tarif`. Pastikan `tbl_ruas` punya baris dengan `ruas_id` yang sama dengan `RUAS_ID`.
5. Isi `tbl_gerbang` dengan seluruh gerbang milik ruas ini beserta kredensial DB lokal masing-masing gerbang (`host`, `port`, `database`, `user`, `pass`) — ini dipakai untuk koneksi `mysql2` dinamis. Pastikan DB fisik di tiap gerbang sudah ada (`tbl_pegawai`, `tbl_dasar_tarif`, `tbl_tarif_open`, `tbl_tarif_exit`, `tbl_durasi`, `tbl_blacklist`).
6. Set `DB_INTEGRASI_HOST`/`PORT`/`DATABASE`/`USERNAME`/`PASSWORD` ke DB integrasi nasional (`integrasi_bcds`), dan pastikan bersama tim pusat bahwa `RUAS_ID` ruas ini sudah terdaftar di `tbl_ruas` serta gerbang-gerbangnya di `tbl_gerbang` pada DB integrasi tersebut (dibutuhkan untuk sinkronisasi blacklist kartu).
7. Set `PUBLIC_KEY`/`PRIVATE_KEY` (kunci RSA enkripsi data kartu RFID) — koordinasikan dengan tim pusat apakah kunci ini shared atau unik per ruas.
8. `php artisan migrate` (hanya untuk tabel default Laravel), `php artisan config:cache`, `php artisan storage:link` bila perlu.
9. Buat satu baris `tbl_pegawai` dengan `jabatan_id = 1` dan `activated = 1` — hanya jabatan ini yang diizinkan login ke aplikasi (lihat `AuthCT::loginAction`).
10. Siapkan service pembaca kartu RFID lokal (WebSocket `ws://localhost:4949`, lihat `public/assets/js/admin/clientapi.js`) di komputer yang tersambung ke reader kartu.
11. Uji: login, cek dashboard, cek dropdown ruas/gerbang menampilkan data yang benar, dan cek badge ruas di modul kartu menampilkan `RUAS_NAME` yang sesuai.

> Dokumentasi lebih lengkap (PRD, ERD, arsitektur, dan catatan teknis) ada di Notion — lihat link yang dibagikan tim.

## Changelog

Semua perubahan penting pada aplikasi ini didokumentasikan di sini. Format mengikuti [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), dan penomoran versi mengikuti [Semantic Versioning](https://semver.org/).

### [1.1.0] - 2026-08-06

#### Ditambahkan
- Environment variable `RUAS_ID` dan `RUAS_NAME` beserta `config/ruas.php`, sehingga ruas jalan tol yang dilayani oleh sebuah instance diatur lewat `.env`, bukan hardcode di kode.
- Environment variable `APP_VERSION` dan `config('app.version')` untuk melacak versi aplikasi yang di-deploy.

#### Diubah
- `Select2CT::getOptionNama()` dan `KartuCT::getOptionNama()` kini memfilter berdasarkan `config('ruas.id')`, bukan nilai hardcode `'b001'`.
- Render badge ruas di `KartuCT` serta helper JS `tipeRuas()` (view `bacaKartu`, `perpanjangKartu`, `whitelist_update`) kini dibandingkan terhadap `config('ruas.id')`/`config('ruas.name')`, bukan case hardcode `'B001'`/`'JMJ'`.
