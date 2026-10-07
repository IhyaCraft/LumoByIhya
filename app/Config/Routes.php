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
