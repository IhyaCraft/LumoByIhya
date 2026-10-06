<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\OtpModel;

class Auth extends BaseController
{
    protected UserModel $userModel;
protected OtpModel $otpModel;

public function __construct()
{
    $this->userModel = new UserModel();
    $this->otpModel = new OtpModel();
}

    public function login()
    {
        $data = [
            'title' => 'CodeJourney - Start Your Coding Journey'
        ];

        return view('auth/VLogin', $data);
    }

    public function proses_login()
    {
        $rules = [
            'email' => 'required|valid_email',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim($this->request->getPost('email')));
        $password = $this->request->getPost('password');

        $userModel = new UserModel();

        $user = $userModel
            ->where('email', $email)
            ->first();

        if (!$user) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email tidak terdaftar.');
        }

        if (!password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Password Anda salah.');
        }

        if ($user['status'] === 'pending') {
            session()->set([
                'otp_user_id' => $user['id']
            ]);

            return redirect()->to(site_url('auth/verifikasi'))
                ->with('error', 'Akun belum diverifikasi. Silakan masukkan kode OTP.');
        }

        if ($user['status'] === 'blocked') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun kamu telah diblokir.');
        }

        if ($user['status'] === 'active') {
            session()->regenerate();

            session()->set([
                'user_id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'status' => $user['status'],
                'isLoggedIn' => true
            ]);

            return redirect()->to(site_url('menu'));
        }
    }

    public function daftar()
{
    return view('auth/VDaftar', [
        'judul' => 'Daftar — Lumo'
    ]);
}
public function prosesDaftar()
{
    $rules = [
        'name' => 'required|min_length[3]|max_length[100]',
        'email' => 'required|valid_email|max_length[255]',
        'password' => 'required|min_length[8]|max_length[255]'
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $nama = trim((string) $this->request->getPost('name'));
    $email = strtolower(trim((string) $this->request->getPost('email')));
    $password = (string) $this->request->getPost('password');

    $existingUser = $this->userModel
        ->where('email', $email)
        ->first();

    if ($existingUser) {
        if ($existingUser['status'] === 'active') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Email sudah terdaftar.');
        }

        if ($existingUser['status'] === 'pending') {
            $this->otpModel
                ->where('user_id', $existingUser['id'])
                ->where('type', 'register')
                ->where('verified_at', null)
                ->delete();

            $otp = (string) random_int(100000, 999999);

            $this->otpModel->insert([
                'user_id' => $existingUser['id'],
                'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
                'type' => 'register',
                'expires_at' => date('Y-m-d H:i:s', time() + 300),
                'attempts' => 0,
                'verified_at' => null,
                'created_at' => date('Y-m-d H:i:s')
            ]);

            $mailer = service('email');

            $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
            $mailer->setTo($email);
            $mailer->setSubject('Kode Verifikasi Baru — Lumo');
            $mailer->setMessage(
                '<h2>Verifikasi Email Lumo</h2>
                <p>Halo ' . esc($existingUser['name']) . ',</p>
                <p>Berikut kode OTP baru untuk menyelesaikan pendaftaran akun Lumo:</p>
                <h1>' . $otp . '</h1>
                <p>Kode OTP berlaku selama 5 menit.</p>
                <p>Jika kamu tidak melakukan pendaftaran, abaikan email ini.</p>'
            );

            if (!$mailer->send()) {
                $this->otpModel
                    ->where('user_id', $existingUser['id'])
                    ->where('type', 'register')
                    ->where('verified_at', null)
                    ->delete();

                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Email OTP gagal dikirim. Silakan coba lagi.');
            }

            session()->set([
                'otp_user_id' => $existingUser['id'],
                'otp_email' => $email,
                'otp_type' => 'register',
                'register_otp_resend_at' => time()
            ]);

            return redirect()->to(site_url('verifikasi'));
        }

        if ($existingUser['status'] === 'blocked') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun dengan email tersebut telah diblokir.');
        }
    }

    $userId = $this->userModel->insert([
        'name' => $nama,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'status' => 'pending'
    ], true);

    if (!$userId) {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal membuat akun.');
    }

    $otp = (string) random_int(100000, 999999);

    $otpId = $this->otpModel->insert([
        'user_id' => $userId,
        'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
        'type' => 'register',
        'expires_at' => date('Y-m-d H:i:s', time() + 300),
        'attempts' => 0,
        'verified_at' => null,
        'created_at' => date('Y-m-d H:i:s')
    ], true);

    if (!$otpId) {
        $this->userModel->delete($userId);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Gagal membuat kode verifikasi.');
    }

    $mailer = service('email');

    $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
    $mailer->setTo($email);
    $mailer->setSubject('Kode Verifikasi — Lumo');
    $mailer->setMessage(
        '<h2>Verifikasi Email Lumo</h2>
        <p>Halo ' . esc($nama) . ',</p>
        <p>Gunakan kode OTP berikut untuk memverifikasi akun Lumo kamu:</p>
        <h1>' . $otp . '</h1>
        <p>Kode OTP berlaku selama 5 menit.</p>
        <p>Jika kamu tidak melakukan pendaftaran, abaikan email ini.</p>'
    );

    if (!$mailer->send()) {
        $this->otpModel->delete($otpId);
        $this->userModel->delete($userId);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Email OTP gagal dikirim. Silakan coba lagi.');
    }

    session()->set([
        'otp_user_id' => $userId,
        'otp_email' => $email,
        'otp_type' => 'register',
        'register_otp_resend_at' => time()
    ]);

    return redirect()->to(site_url('verifikasi'));
}

    public function verifikasi()
{
    $userId = session()->get('otp_user_id');

    if (!$userId) {
        return redirect()->to(site_url('daftar'));
    }

    $lastResend = session()->get('register_otp_resend_at');
    $remaining = 0;

    if ($lastResend) {
        $remaining = max(0, 60 - (time() - $lastResend));
    }

    return view('auth/VVerifikasi', [
        'judul' => 'Verifikasi — Lumo',
        'email' => session()->get('otp_email'),
        'resendRemaining' => $remaining
    ]);

}
public function prosesVerifikasi()
{
    $userId = session()->get('otp_user_id');
    $otp = trim((string) $this->request->getPost('otp'));

    if (!$userId) {
        return redirect()->to(site_url('daftar'));
    }

    if (!preg_match('/^[0-9]{6}$/', $otp)) {
        return redirect()->back()
            ->with('error', 'Kode OTP tidak valid.');
    }

    $otpData = $this->otpModel
        ->where('user_id', $userId)
        ->where('type', 'register')
        ->where('verified_at', null)
        ->orderBy('id', 'DESC')
        ->first();

    if (!$otpData) {
        return redirect()->back()
            ->with('error', 'Kode OTP tidak ditemukan.');
    }

    if (strtotime($otpData['expires_at']) < time()) {
        return redirect()->back()
            ->with('error', 'Kode OTP sudah kedaluwarsa.');
    }

    if ((int) $otpData['attempts'] >= 5) {
        return redirect()->back()
            ->with('error', 'Batas percobaan OTP sudah tercapai.');
    }

    if (!password_verify($otp, $otpData['otp_hash'])) {
        $this->otpModel->update($otpData['id'], [
            'attempts' => (int) $otpData['attempts'] + 1
        ]);

        return redirect()->back()
            ->with('error', 'Kode OTP salah.');
    }

    $now = date('Y-m-d H:i:s');

    $db = db_connect();
    $db->transStart();

    $this->otpModel->update($otpData['id'], [
        'verified_at' => $now
    ]);

    $this->userModel->update($userId, [
        'status' => 'active'
    ]);

    $db->transComplete();

    if ($db->transStatus() === false) {
        return redirect()->back()
            ->with('error', 'Verifikasi gagal. Silakan coba lagi.');
    }

    session()->remove([
        'otp_user_id',
        'otp_email',
        'otp_type',
        'register_otp_resend_at'
    ]);

    return redirect()->to(site_url('masuk'))
        ->with('success', 'Email berhasil diverifikasi. Silakan masuk.');
}
}