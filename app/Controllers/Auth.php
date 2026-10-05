<?php

namespace App\Controllers;

use App\Models\OtpModel;
use App\Models\UserModel;
use Config\Services;

class Auth extends BaseController
{
    protected UserModel $userModel;
    protected OtpModel $otpModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->otpModel = new OtpModel();
    }

    public function login(): string
    {
        return view('auth/VLogin', [
            'judul' => 'Masuk — Lumo'
        ]);
    }

    public function daftar(): string
    {
        return view('auth/VDaftar', [
            'judul' => 'Daftar — Lumo'
        ]);
    }

    public function prosesDaftar()
    {
        $nama = trim((string) $this->request->getPost('name'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        if ($nama === '' || $email === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Semua field wajib diisi.');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return redirect()->back()->withInput()->with('error', 'Format email tidak valid.');
        }

        if (strlen($password) < 8) {
            return redirect()->back()->withInput()->with('error', 'Kata sandi minimal 8 karakter.');
        }

        if ($this->userModel->where('email', $email)->first()) {
            return redirect()->back()->withInput()->with('error', 'Email sudah terdaftar.');
        }

        $db = db_connect();

        $db->transStart();

        $userId = $this->userModel->insert([
            'name' => $nama,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status' => 'pending'
        ], true);

        if (!$userId) {
            $db->transRollback();

            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal.');
        }

        $otp = (string) random_int(100000, 999999);

        $this->otpModel->insert([
            'user_id' => $userId,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'type' => 'register',
            'expires_at' => date('Y-m-d H:i:s', time() + 300),
            'attempts' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->withInput()->with('error', 'Pendaftaran gagal.');
        }

        $mailer = Services::email();

        $mailer->setTo($email);
        $mailer->setSubject('Kode Verifikasi Akun Lumo');
        $mailer->setMessage(
            '<h2>Verifikasi Akun Lumo</h2>
            <p>Halo ' . esc($nama) . ',</p>
            <p>Kode verifikasi akun kamu:</p>
            <h1>' . $otp . '</h1>
            <p>Kode berlaku selama 5 menit.</p>'
        );

        if (!$mailer->send()) {
            return redirect()->back()->withInput()->with('error', 'Kode verifikasi gagal dikirim.');
        }

        session()->regenerate();

        session()->set([
            'otp_user_id' => $userId,
            'otp_email' => $email,
            'otp_type' => 'register'
        ]);

        return redirect()->to(site_url('verifikasi'));
    }

    public function verifikasi(): string
    {
        if (!session()->get('otp_user_id')) {
            return redirect()->to(site_url('daftar'));
        }

        return view('auth/VVerifikasi', [
            'judul' => 'Verifikasi — Lumo',
            'email' => session()->get('otp_email')
        ]);
    }

    public function prosesVerifikasi()
    {
        $userId = session()->get('otp_user_id');
        $otp = trim((string) $this->request->getPost('otp'));

        if (!$userId) {
            return redirect()->to(site_url('daftar'));
        }

        if (!preg_match('/^\d{6}$/', $otp)) {
            return redirect()->back()->with('error', 'Kode OTP tidak valid.');
        }

        $otpData = $this->otpModel
            ->where('user_id', $userId)
            ->where('type', 'register')
            ->where('verified_at', null)
            ->orderBy('id', 'DESC')
            ->first();

        if (!$otpData) {
            return redirect()->back()->with('error', 'Kode OTP tidak ditemukan.');
        }

        if (strtotime($otpData['expires_at']) <= time()) {
            return redirect()->back()->with('error', 'Kode OTP sudah kedaluwarsa.');
        }

        if ((int) $otpData['attempts'] >= 5) {
            return redirect()->back()->with('error', 'Batas percobaan OTP telah tercapai.');
        }

        if (!password_verify($otp, $otpData['otp_hash'])) {
            $this->otpModel->update($otpData['id'], [
                'attempts' => (int) $otpData['attempts'] + 1
            ]);

            return redirect()->back()->with('error', 'Kode OTP salah.');
        }

        $db = db_connect();

        $db->transStart();

        $this->otpModel->update($otpData['id'], [
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        $this->userModel->update($userId, [
            'status' => 'active'
        ]);

        $db->transComplete();

        if ($db->transStatus() === false) {
            return redirect()->back()->with('error', 'Verifikasi gagal.');
        }

        session()->remove([
            'otp_user_id',
            'otp_email',
            'otp_type'
        ]);

        return redirect()->to(site_url('masuk'))
            ->with('success', 'Akun berhasil diverifikasi. Silakan masuk.');
    }
}