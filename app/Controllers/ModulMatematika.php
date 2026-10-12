<?php

namespace App\Controllers;

class ModulMatematika extends BaseController
{
   
public function index(): string|\CodeIgniter\HTTP\RedirectResponse
{
    if (! session()->get('isLoggedIn')) {
        return redirect()->to(site_url('masuk'));
    }

    $idUser = (int) session()->get('user_id');

    $model = new \App\Models\ProgresPelajaranModel();

    $rows = $model
        ->where('id', $idUser)
        ->findAll();

    $progres = [];

    foreach ($rows as $row) {
        $progres[$row['slug_pelajaran']] = [
            'skor'    => (int) $row['skor'],
            'selesai' => (bool) $row['selesai'],
        ];
    }

    return view('pelajaran/VModulMatematika', [
        'progres' => $progres,
    ]);
}

}