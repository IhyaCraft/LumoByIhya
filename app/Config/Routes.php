<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('masuk', 'Auth::login');
$routes->post('masuk', 'Auth::proses_login');


$routes->post('logout', 'Auth::logout');

 
$routes->get('daftar', 'Auth::daftar');
$routes->post('daftar', 'Auth::prosesDaftar');

$routes->get('verifikasi', 'Auth::verifikasi');
$routes->post('verifikasi', 'Auth::prosesVerifikasi');

$routes->post('kirim-ulang-otp', 'Auth::kirimUlangOtp');
$routes->get('home', 'Home::dashboard');


$routes->get('auth/lupa-password', 'Auth::lupaPassword');
$routes->post('auth/lupa-password', 'Auth::prosesLupaPassword');

$routes->get('auth/verifikasi-reset-password', 'Auth::verifikasiResetPassword');
$routes->post('auth/verifikasi-reset-password', 'Auth::prosesVerifikasiResetPassword');

$routes->post('auth/kirim-ulang-otp-reset', 'Auth::kirimUlangOtpReset');

$routes->get('auth/reset-password', 'Auth::resetPassword');
$routes->post('auth/reset-password', 'Auth::prosesResetPassword');

$routes->get('profil', 'Profil::index');

$routes->get('beranda-sudah-login', 'Home::berandaSudahLogin');

$routes->get('pelajaran/matematika', 'ModulMatematika::index');


$routes->get('admin', 'Admin::index', ['filter' => 'admin']);

$routes->group('admin/modul', ['filter' => 'admin'], static function ($routes) {
    $routes->get('/', 'Admin\Modul::index');
    $routes->get('tambah', 'Admin\Modul::tambah');
    $routes->get('edit/(:num)', 'Admin\Modul::edit/$1');
    $routes->post('arsipkan/(:num)', 'Admin\Modul::arsipkan/$1');
    $routes->post('pulihkan/(:num)', 'Admin\Modul::pulihkan/$1');
    $routes->post('tambah', 'Admin\Modul::prosesTambah');
    $routes->post('edit/(:num)', 'Admin\Modul::prosesEdit/$1');
});