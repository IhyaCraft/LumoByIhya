## Aturan Penamaan File dan Class

1. Controller: Nama file dan class diawali dengan huruf kapital, menggunakan format `PascalCase`. Contoh: `Auth.php` dengan class `Auth`, dan `Home.php` dengan class `Home`.

2. View: Nama file View diawali dengan huruf `V`, diikuti nama yang menjelaskan fungsi halaman. Contoh: `VLogin.php`, `VDaftar.php`, `VVerifikasi.php`, dan `VHome.php`.

3. Model: Nama file dan class menggunakan format `PascalCase` dan diakhiri dengan `Model`. Contoh: `UserModel.php` dengan class `UserModel`, dan `OtpModel.php` dengan class `OtpModel`.

4. CSS: Nama file menggunakan huruf kecil dan format `kebab-case` agar konsisten. Contoh: `login.css`, `daftar.css`, dan `reset-password.css`.

5. JavaScript: Nama file menggunakan huruf kecil dan format `kebab-case`. Contoh: `login.js`, `daftar.js`, dan `reset-password.js`.

6. Konsistensi: Nama file, class, dan pemanggilannya harus sesuai. Setiap file harus memiliki fungsi yang jelas dan ditempatkan pada direktori sesuai jenisnya.

 
 1. Auth.php — Controller Autentikasi

Controller yang menangani proses autentikasi pengguna, mulai dari pendaftaran akun, verifikasi OTP melalui email, login, logout, hingga fitur lupa dan reset kata sandi. Controller ini menghubungkan permintaan pengguna dengan model, proses validasi, pengelolaan sesi, dan tampilan autentikasi yang sesuai.

 2. Home.php — Controller Halaman Utama

Controller yang menangani halaman utama aplikasi Lumo. Controller ini mengatur pemanggilan tampilan beranda serta data yang diperlukan untuk menampilkan halaman kepada pengguna.