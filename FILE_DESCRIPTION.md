 File Descriptions — Lumo

Dokumentasi ini berisi penjelasan fungsi file, khususnya Controller dan View, serta aturan penamaan yang digunakan dalam pengembangan aplikasi Lumo berbasis CodeIgniter 4 (CI4).

# 1. Controller

 `Auth.php`
Controller yang menangani proses autentikasi pengguna, mulai dari pendaftaran akun, verifikasi OTP melalui email, login, logout, hingga fitur lupa dan reset kata sandi. Controller ini menghubungkan permintaan pengguna dengan model, proses validasi, pengelolaan sesi, dan tampilan autentikasi yang sesuai.

 `Home.php`
Controller yang menangani halaman utama aplikasi Lumo. Controller ini mengatur pemanggilan tampilan beranda serta data yang diperlukan untuk menampilkan halaman kepada pengguna.

# 2. View

 `VLogin.php`
File View yang digunakan untuk menampilkan halaman login pada aplikasi Lumo, termasuk formulir yang digunakan pengguna untuk masuk ke akun mereka.

 `VDaftar.php`
File View yang digunakan untuk menampilkan halaman pendaftaran akun baru pada aplikasi Lumo, termasuk formulir pendaftaran yang digunakan pengguna untuk membuat akun.

 `VVerifikasi.php`
File View yang digunakan untuk menampilkan halaman verifikasi kode OTP yang dikirim ke email pengguna saat proses pendaftaran akun Lumo.

 `VLupaPassword.php`
File View yang digunakan untuk menampilkan halaman konfirmasi email saat pengguna lupa kata sandi, sebelum melanjutkan ke proses verifikasi dan reset kata sandi.

 `VVerifikasiResetPassword.php`
File View yang digunakan untuk menampilkan halaman verifikasi kode OTP yang dikirim ke email pengguna dalam proses pemulihan kata sandi akun Lumo.

 `VResetPassword.php`
File View yang digunakan untuk menampilkan halaman pengubahan kata sandi agar pengguna dapat membuat kata sandi baru pada akun Lumo.

# 3. Aturan Penamaan File dan Class

## Controller
- Nama file dan class diawali dengan huruf kapital dan menggunakan format `PascalCase`.
- Nama file harus sesuai dengan nama class.
- Contoh: `Auth.php` dengan class `Auth`, serta `Home.php` dengan class `Home`.

## View
- Nama file View diawali dengan huruf `V`, diikuti nama yang menjelaskan fungsi halaman.
- Contoh: `VLogin.php`, `VDaftar.php`, `VVerifikasi.php`, dan `VHome.php`.

## Model
- Nama file dan class menggunakan format `PascalCase` dan diakhiri dengan `Model`.
- Nama file harus sesuai dengan nama class.
- Contoh: `UserModel.php` dengan class `UserModel`, dan `OtpModel.php` dengan class `OtpModel`.

## CSS
- Nama file menggunakan huruf kecil dan format `kebab-case` agar konsisten.
- Contoh: `login.css`, `daftar.css`, dan `reset-password.css`.

## JavaScript
- Nama file menggunakan huruf kecil dan format `kebab-case`.
- Contoh: `login.js`, `daftar.js`, dan `reset-password.js`.

## Konsistensi
- Nama file, class, dan pemanggilannya harus sesuai.
- Setiap file harus memiliki fungsi yang jelas dan ditempatkan pada direktori sesuai jenisnya.
- Perubahan fungsi file harus diikuti dengan pembaruan dokumentasi agar informasi tetap akurat.