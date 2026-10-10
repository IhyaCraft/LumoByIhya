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
        return view('auth/VLogin', [
            'judul' => 'Masuk — Lumo'
        ]);
    }

    public function proses_login()
    {
        $rules = [
            'email' => 'required|valid_email|max_length[255]',
            'password' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        $user = $this->userModel
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
                ->with('error', 'Password kamu salah.');
        }

        if ($user['status'] === 'pending') {
            session()->set([
                'otp_user_id' => $user['id'],
                'otp_email' => $user['email'],
                'otp_type' => 'register'
            ]);

            return redirect()->to(site_url('verifikasi'))
                ->with('error', 'Akun belum diverifikasi. Silakan masukkan kode OTP.');
        }

        if ($user['status'] === 'blocked') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun kamu telah diblokir.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Akun tidak dapat digunakan.');
        }

        session()->regenerate();

        session()->set([
            'user_id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'status' => $user['status'],
            'isLoggedIn' => true
        ]);

        return redirect()->to(site_url('home'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(site_url('masuk'))
            ->with('success', 'Kamu berhasil keluar dari Lumo.');
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

                $otpId = $this->otpModel->insert([
                    'user_id' => $existingUser['id'],
                    'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
                    'type' => 'register',
                    'expires_at' => date('Y-m-d H:i:s', time() + 300),
                    'attempts' => 0,
                    'verified_at' => null,
                    'created_at' => date('Y-m-d H:i:s')
                ], true);

                if (!$otpId) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Gagal membuat kode OTP.');
                }

                $mailer = service('email');
                $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
                $mailer->setTo($email);
                $mailer->setSubject('Kode Verifikasi Baru — Lumo');
                $mailer->setMessage(
                    '<h2>Verifikasi Email Lumo</h2>
                    <p>Halo ' . esc($existingUser['name']) . ',</p>
                    <p>Berikut kode OTP baru untuk menyelesaikan pendaftaran akun Lumo:</p>
                    <h1>' . esc($otp) . '</h1>
                    <p>Kode OTP berlaku selama 5 menit.</p>
                    <p>Jika kamu tidak melakukan pendaftaran, abaikan email ini.</p>'
                );

                if (!$mailer->send()) {
                    $this->otpModel->delete($otpId);

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
            <h1>' . esc($otp) . '</h1>
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

        if (!$userId || session()->get('otp_type') !== 'register') {
            return redirect()->to(site_url('daftar'));
        }

        $lastResend = (int) session()->get('register_otp_resend_at');
        $remaining = $lastResend
            ? max(0, 60 - (time() - $lastResend))
            : 0;

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

        if (!$userId || session()->get('otp_type') !== 'register') {
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

        if (strtotime($otpData['expires_at']) <= time()) {
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

        $db = db_connect();
        $db->transBegin();

        $otpUpdated = $this->otpModel->update($otpData['id'], [
            'verified_at' => date('Y-m-d H:i:s')
        ]);

        $userUpdated = $this->userModel->update($userId, [
            'status' => 'active'
        ]);

        if (
            $otpUpdated === false ||
            $userUpdated === false ||
            $db->transStatus() === false
        ) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Verifikasi gagal. Silakan coba lagi.');
        }

        $db->transCommit();

        session()->remove([
            'otp_user_id',
            'otp_email',
            'otp_type',
            'register_otp_resend_at',
            'user_id',
            'name',
            'email',
            'status',
            'isLoggedIn'
        ]);

        session()->regenerate();

        return redirect()->to(site_url('masuk'))
            ->with('success', 'Email berhasil diverifikasi. Silakan masuk.');
    }

    public function kirimUlangOtp()
    {
        $userId = session()->get('otp_user_id');
        $email = session()->get('otp_email');

        if (!$userId || !$email || session()->get('otp_type') !== 'register') {
            return redirect()->to(site_url('daftar'))
                ->with('error', 'Sesi verifikasi tidak ditemukan.');
        }

        $lastResend = (int) session()->get('register_otp_resend_at');

        if ($lastResend) {
            $remaining = 60 - (time() - $lastResend);

            if ($remaining > 0) {
                return redirect()->to(site_url('verifikasi'))
                    ->with('error', 'Tunggu ' . $remaining . ' detik sebelum mengirim ulang OTP.');
            }
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['status'] !== 'pending' || $user['email'] !== $email) {
            return redirect()->to(site_url('daftar'))
                ->with('error', 'Akun tidak dapat melakukan verifikasi.');
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
            return redirect()->to(site_url('verifikasi'))
                ->with('error', 'Gagal membuat kode OTP baru.');
        }

        $mailer = service('email');
        $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
        $mailer->setTo($email);
        $mailer->setSubject('Kode Verifikasi Baru — Lumo');
        $mailer->setMessage(
            '<h2>Verifikasi Email Lumo</h2>
            <p>Halo ' . esc($user['name']) . ',</p>
            <p>Berikut kode OTP baru untuk memverifikasi akun Lumo kamu:</p>
            <h1>' . esc($otp) . '</h1>
            <p>Kode OTP berlaku selama 5 menit.</p>
            <p>Jika kamu tidak melakukan permintaan ini, abaikan email ini.</p>'
        );

        if (!$mailer->send()) {
            $this->otpModel->delete($otpId);

            return redirect()->to(site_url('verifikasi'))
                ->with('error', 'Email OTP gagal dikirim. Silakan coba lagi.');
        }

        $this->otpModel
            ->where('user_id', $userId)
            ->where('type', 'register')
            ->where('verified_at', null)
            ->where('id !=', $otpId)
            ->delete();

        session()->set([
            'register_otp_resend_at' => time()
        ]);

        return redirect()->to(site_url('verifikasi'))
            ->with('success', 'Kode OTP baru berhasil dikirim.');
    }

    public function lupaPassword()
    {
        return view('auth/VLupaPassword', [
            'judul' => 'Lupa Kata Sandi — Lumo'
        ]);
    }

    public function prosesLupaPassword()
    {
        $rules = [
            'email' => 'required|valid_email|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $email = strtolower(trim((string) $this->request->getPost('email')));

        $user = $this->userModel
            ->where('email', $email)
            ->where('status', 'active')
            ->first();

        if (!$user) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('success', 'Jika email terdaftar, petunjuk reset kata sandi akan dikirim.');
        }

        $otp = (string) random_int(100000, 999999);

        $otpId = $this->otpModel->insert([
            'user_id' => $user['id'],
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'type' => 'password_reset',
            'expires_at' => date('Y-m-d H:i:s', time() + 300),
            'attempts' => 0,
            'verified_at' => null,
            'created_at' => date('Y-m-d H:i:s')
        ], true);

        if (!$otpId) {
            return redirect()->back()
                ->with('error', 'Permintaan reset belum dapat diproses. Silakan coba lagi.');
        }

        $mailer = service('email');
        $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
        $mailer->setTo($email);
        $mailer->setSubject('Reset Kata Sandi — Lumo');
        $mailer->setMessage(
            '<h2>Reset Kata Sandi Lumo</h2>
            <p>Halo ' . esc($user['name']) . ',</p>
            <p>Gunakan kode berikut untuk memverifikasi permintaan reset kata sandi:</p>
            <h1>' . esc($otp) . '</h1>
            <p>Kode OTP berlaku selama 5 menit.</p>
            <p>Jika kamu tidak meminta reset kata sandi, abaikan email ini.</p>'
        );

        if (!$mailer->send()) {
            $this->otpModel->delete($otpId);

            return redirect()->back()
                ->with('error', 'Email OTP gagal dikirim. Silakan coba lagi.');
        }

        $this->otpModel
            ->where('user_id', $user['id'])
            ->where('type', 'password_reset')
            ->where('verified_at', null)
            ->where('id !=', $otpId)
            ->delete();

        $this->clearResetSession();

        session()->set([
            'reset_user_id' => $user['id'],
            'reset_email' => $email,
            'reset_otp_id' => $otpId,
            'reset_otp_resend_at' => time()
        ]);

        return redirect()->to(site_url('auth/verifikasi-reset-password'));
    }

    public function verifikasiResetPassword()
    {
        $userId = session()->get('reset_user_id');
        $email = session()->get('reset_email');
        $otpId = session()->get('reset_otp_id');

        if (!$userId || !$email || !$otpId) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak ditemukan.');
        }

        if (session()->get('reset_verified_at')) {
            return redirect()->to(site_url('auth/reset-password'));
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['email'] !== $email || $user['status'] !== 'active') {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak valid.');
        }

        $otpData = $this->otpModel
            ->where('id', $otpId)
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->where('verified_at', null)
            ->first();

        if (!$otpData) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Silakan minta kode OTP reset kata sandi terlebih dahulu.');
        }

        $lastResend = (int) session()->get('reset_otp_resend_at');
        $remaining = $lastResend
            ? max(0, 60 - (time() - $lastResend))
            : 0;

        return view('auth/VVerifikasiResetPassword', [
            'judul' => 'Verifikasi Reset Kata Sandi — Lumo',
            'email' => $email,
            'resendRemaining' => $remaining
        ]);
    }

    public function prosesVerifikasiResetPassword()
    {
        $userId = session()->get('reset_user_id');
        $email = session()->get('reset_email');
        $otpId = session()->get('reset_otp_id');
        $otp = trim((string) $this->request->getPost('otp'));

        if (!$userId || !$email || !$otpId) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak ditemukan.');
        }

        if (session()->get('reset_verified_at')) {
            return redirect()->to(site_url('auth/reset-password'));
        }

        if (!preg_match('/^[0-9]{6}$/', $otp)) {
            return redirect()->back()
                ->with('error', 'Masukkan kode OTP 6 digit yang valid.');
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['email'] !== $email || $user['status'] !== 'active') {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak valid.');
        }

        $otpData = $this->otpModel
            ->where('id', $otpId)
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->where('verified_at', null)
            ->first();

        if (!$otpData) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Kode OTP tidak ditemukan atau sudah digunakan.');
        }

        if (strtotime($otpData['expires_at']) <= time()) {
            return redirect()->back()
                ->with('error', 'Kode OTP sudah kedaluwarsa. Silakan kirim ulang.');
        }

        if ((int) $otpData['attempts'] >= 5) {
            return redirect()->back()
                ->with('error', 'Batas 5 percobaan OTP sudah tercapai. Silakan kirim ulang kode.');
        }

        if (!password_verify($otp, $otpData['otp_hash'])) {
            $this->otpModel->update($otpId, [
                'attempts' => (int) $otpData['attempts'] + 1
            ]);

            return redirect()->back()
                ->with('error', 'Kode OTP salah.');
        }

        $verifiedAt = time();

        $updated = $this->otpModel->update($otpId, [
            'verified_at' => date('Y-m-d H:i:s', $verifiedAt)
        ]);

        if ($updated === false) {
            return redirect()->back()
                ->with('error', 'Verifikasi OTP gagal. Silakan coba lagi.');
        }

        session()->set([
            'reset_verified_at' => $verifiedAt,
            'reset_verified_otp_id' => $otpId
        ]);

        return redirect()->to(site_url('auth/reset-password'))
            ->with('success', 'OTP berhasil diverifikasi. Silakan buat kata sandi baru.');
    }

    public function kirimUlangOtpReset()
    {
        $userId = session()->get('reset_user_id');
        $email = session()->get('reset_email');
        $otpIdLama = session()->get('reset_otp_id');

        if (!$userId || !$email || !$otpIdLama) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak ditemukan.');
        }

        if (session()->get('reset_verified_at')) {
            return redirect()->to(site_url('auth/reset-password'));
        }

        $lastResend = (int) session()->get('reset_otp_resend_at');

        if ($lastResend) {
            $remaining = 60 - (time() - $lastResend);

            if ($remaining > 0) {
                return redirect()->to(site_url('auth/verifikasi-reset-password'))
                    ->with('error', 'Tunggu ' . $remaining . ' detik sebelum mengirim ulang OTP.');
            }
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['email'] !== $email || $user['status'] !== 'active') {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Akun tidak dapat melakukan reset kata sandi.');
        }

        $otp = (string) random_int(100000, 999999);

        $otpIdBaru = $this->otpModel->insert([
            'user_id' => $userId,
            'otp_hash' => password_hash($otp, PASSWORD_DEFAULT),
            'type' => 'password_reset',
            'expires_at' => date('Y-m-d H:i:s', time() + 300),
            'attempts' => 0,
            'verified_at' => null,
            'created_at' => date('Y-m-d H:i:s')
        ], true);

        if (!$otpIdBaru) {
            return redirect()->to(site_url('auth/verifikasi-reset-password'))
                ->with('error', 'Gagal membuat kode OTP baru.');
        }

        $mailer = service('email');
        $mailer->setFrom('lumoeducationofc@gmail.com', 'Lumo Education');
        $mailer->setTo($email);
        $mailer->setSubject('Kode Reset Kata Sandi Baru — Lumo');
        $mailer->setMessage(
            '<h2>Reset Kata Sandi Lumo</h2>
            <p>Halo ' . esc($user['name']) . ',</p>
            <p>Gunakan kode OTP berikut untuk melanjutkan reset kata sandi:</p>
            <h1>' . esc($otp) . '</h1>
            <p>Kode OTP berlaku selama 5 menit.</p>
            <p>Jika kamu tidak meminta reset kata sandi, abaikan email ini.</p>'
        );

        if (!$mailer->send()) {
            $this->otpModel->delete($otpIdBaru);

            return redirect()->to(site_url('auth/verifikasi-reset-password'))
                ->with('error', 'Email OTP gagal dikirim. Silakan coba lagi.');
        }

        $this->otpModel
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->where('verified_at', null)
            ->where('id !=', $otpIdBaru)
            ->delete();

        session()->remove([
            'reset_verified_at',
            'reset_verified_otp_id'
        ]);

        session()->set([
            'reset_otp_id' => $otpIdBaru,
            'reset_otp_resend_at' => time()
        ]);

        return redirect()->to(site_url('auth/verifikasi-reset-password'))
            ->with('success', 'Kode OTP baru berhasil dikirim.');
    }

    public function resetPassword()
    {
        $userId = session()->get('reset_user_id');
        $email = session()->get('reset_email');
        $otpId = session()->get('reset_otp_id');
        $verifiedOtpId = session()->get('reset_verified_otp_id');
        $verifiedAt = (int) session()->get('reset_verified_at');

        if (
            !$userId ||
            !$email ||
            !$otpId ||
            !$verifiedAt ||
            (string) $verifiedOtpId !== (string) $otpId
        ) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        if ($verifiedAt > time() || time() - $verifiedAt > 900) {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi sudah kedaluwarsa. Silakan mulai kembali.');
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['email'] !== $email || $user['status'] !== 'active') {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak valid.');
        }

        $otpData = $this->otpModel
            ->where('id', $otpId)
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->where('verified_at IS NOT NULL', null, false)
            ->first();

        if (!$otpData) {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Verifikasi OTP tidak ditemukan. Silakan mulai kembali.');
        }

        return view('auth/VResetPassword', [
            'judul' => 'Reset Kata Sandi — Lumo'
        ]);
    }

    public function prosesResetPassword()
    {
        $userId = session()->get('reset_user_id');
        $email = session()->get('reset_email');
        $otpId = session()->get('reset_otp_id');
        $verifiedOtpId = session()->get('reset_verified_otp_id');
        $verifiedAt = (int) session()->get('reset_verified_at');

        if (
            !$userId ||
            !$email ||
            !$otpId ||
            !$verifiedAt ||
            (string) $verifiedOtpId !== (string) $otpId
        ) {
            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Silakan verifikasi OTP terlebih dahulu.');
        }

        if ($verifiedAt > time() || time() - $verifiedAt > 900) {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi sudah kedaluwarsa. Silakan mulai kembali.');
        }

        $user = $this->userModel->find($userId);

        if (!$user || $user['email'] !== $email || $user['status'] !== 'active') {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Sesi reset kata sandi tidak valid.');
        }

        $otpData = $this->otpModel
            ->where('id', $otpId)
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->where('verified_at IS NOT NULL', null, false)
            ->first();

        if (!$otpData) {
            $this->clearResetSession();

            return redirect()->to(site_url('auth/lupa-password'))
                ->with('error', 'Verifikasi OTP tidak ditemukan. Silakan mulai kembali.');
        }

        $rules = [
            'password' => 'required|min_length[8]|max_length[255]',
            'konfirmasi_password' => 'required|matches[password]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()
                ->with('errors', $this->validator->getErrors());
        }

        $password = (string) $this->request->getPost('password');

        $db = db_connect();
        $db->transBegin();

        $updated = $this->userModel->update($userId, [
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        if ($updated === false) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Password gagal diperbarui. Silakan coba lagi.');
        }

        $deleted = $this->otpModel
            ->where('user_id', $userId)
            ->where('type', 'password_reset')
            ->delete();

        if ($deleted === false || $db->transStatus() === false) {
            $db->transRollback();

            return redirect()->back()
                ->with('error', 'Reset kata sandi gagal diproses. Silakan coba lagi.');
        }

        $db->transCommit();

        $this->clearResetSession();

        return redirect()->to(site_url('masuk'))
            ->with('success', 'Kata sandi berhasil diperbarui. Silakan masuk dengan kata sandi baru.');
    }

    private function clearResetSession(): void
    {
        session()->remove([
            'reset_user_id',
            'reset_email',
            'reset_otp_id',
            'reset_otp_resend_at',
            'reset_verified_at',
            'reset_verified_otp_id'
        ]);
    }
}