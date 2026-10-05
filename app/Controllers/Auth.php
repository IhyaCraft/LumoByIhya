<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;
use Config\Services;

class Auth extends BaseController
{
    public function login(): string
    {
        return view('auth/VLogin', ['judul' => 'Masuk — Lumo']);
    }

    public function daftar(): string
    {
        return view('auth/VDaftar', ['judul' => 'Daftar — Lumo']);
    }

    public function prosesDaftar()
    {
        $nama = trim($this->request->getPost('name'));
        $email = trim($this->request->getPost('email'));
        $password = $this->request->getPost('password');

        if ($nama === '' || $email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Format email tidak valid.');
        }

        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'Kata sandi minimal 8 karakter.');
        }

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $email)
            ->first();

        if ($user) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        $userId = $userModel->insert([
            'name' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status' => 'pending'
        ], true);

        if (!$userId) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal.');
        }

        $otp = (string) random_int(100000, 999999);

        $otpModel = new OtpModel();

        $otpModel->insert([
            'user_id' => $userId,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'type' => 'register',
            'expires_at' => date('Y-m-d H:i:s', time() + 300),
            'attempts' => 0,
            'verified_at' => null,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $emailService = Services::email();

        $emailService->setTo($email);
        $emailService->setSubject('Kode Verifikasi Akun Lumo');
        $emailService->setMessage(
            '<h2>Verifikasi Akun Lumo</h2>
            <p>Halo ' . esc($nama) . ',</p>
            <p>Gunakan kode berikut untuk memverifikasi akun kamu:</p>
            <h1>' . $otp . '</h1>
            <p>Kode ini berlaku selama 5 menit.</p>'
        );

        if (!$emailService->send()) {
            $otpModel->where('id', $otpModel->getInsertID())->delete();
            $userModel->delete($userId);

            return redirect()->back()->withInput()->with('error', 'Kode OTP gagal dikirim. Silakan coba lagi.');
        }

        session()->set([
            'otp_user_id' => $userId,
            'otp_email' => $email,
            'otp_type' => 'register'
        ]);

        return redirect()->to(site_url('verifikasi'));
    }
}