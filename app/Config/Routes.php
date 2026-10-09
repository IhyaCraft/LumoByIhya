<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('masuk', 'Auth::login');
$routes->post('masuk', 'Auth::proses_login');

 
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