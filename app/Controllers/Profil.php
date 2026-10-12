<?php

namespace App\Controllers;

use App\Models\UserModel;

class Profil extends BaseController
{
    public function index()
    {
        if (! session()->get('isLoggedIn')) {
            return redirect()->to(site_url('masuk'));
        }

        $userId = session()->get('user_id');

        $userModel = new UserModel();
        $user = $userModel->select('id, name, email, status')
            ->find($userId);

        if (! $user || $user['status'] !== 'active') {
            session()->destroy();

            return redirect()->to(site_url('masuk'))
                ->with('error', 'Silakan masuk kembali ke akun kamu.');
        }

        return view('profil/VProfilUtama', [
            'judul' => 'Profil Saya — Lumo',
            'user' => $user,
        ]);
    }
}
