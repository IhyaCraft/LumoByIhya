<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ModulPelajaranModel;

class Modul extends BaseController
{
    protected $modulModel;

    public function __construct()
    {
        $this->modulModel = new ModulPelajaranModel();
    }

    public function index()
    {
        return view('admin/modul/VModul', [
            'title' => 'Kelola Modul Pelajaran — Lumo',
            'modulAktif' => $this->modulModel->getModulAktif(),
            'modulArsip' => $this->modulModel->getModulArsip(),
        ]);
    }

    public function tambah()
    {
        return view('admin/modul/VTambahModul', [
            'title' => 'Tambah Modul — Lumo',
        ]);
    }

    public function edit(int $id)
    {
        $modul = $this->modulModel->find($id);

        if (!$modul) {
            return redirect()->to(site_url('admin/modul'))
                ->with('error', 'Modul tidak ditemukan.');
        }

        return view('admin/modul/VEditModul', [
            'title' => 'Edit Modul — Lumo',
            'modul' => $modul,
        ]);
    }

    public function arsipkan(int $id)
    {
        $modul = $this->modulModel->find($id);

        if (!$modul) {
            return redirect()->to(site_url('admin/modul'))
                ->with('error', 'Modul tidak ditemukan.');
        }

        if (!$this->modulModel->arsipkan($id)) {
            return redirect()->to(site_url('admin/modul'))
                ->with('error', 'Modul gagal diarsipkan.');
        }

        return redirect()->to(site_url('admin/modul'))
            ->with('success', 'Modul berhasil diarsipkan.');
    }

    public function pulihkan(int $id)
    {
        $modul = $this->modulModel->find($id);

        if (!$modul) {
            return redirect()->to(site_url('admin/modul'))
                ->with('error', 'Modul tidak ditemukan.');
        }

        if (!$this->modulModel->pulihkan($id)) {
            return redirect()->to(site_url('admin/modul'))
                ->with('error', 'Modul gagal dipulihkan.');
        }

        return redirect()->to(site_url('admin/modul'))
            ->with('success', 'Modul berhasil dipulihkan.');
    }

    

public function prosesTambah()
{
    $rules = [
        'judul' => 'required|max_length[150]',
        'deskripsi' => 'permit_empty',
        'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
        'urutan' => 'required|integer|greater_than_equal_to[0]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $judul = trim($this->request->getPost('judul'));
    $slugDasar = url_title($judul, '-', true);

    if ($slugDasar === '') {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Judul modul tidak menghasilkan slug yang valid.');
    }

    $slug = $slugDasar;
    $nomor = 1;

    while ($this->modulModel->where('slug', $slug)->first()) {
        $slug = $slugDasar . '-' . $nomor++;
    }

    $gambar = null;
    $file = $this->request->getFile('gambar');

    if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'File gambar tidak valid.');
        }

        $direktori = FCPATH . 'uploads/modul';

        if (!is_dir($direktori) && !mkdir($direktori, 0755, true) && !is_dir($direktori)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Folder upload gambar gagal dibuat.');
        }

        $namaGambar = $file->getRandomName();

        if (!$file->move($direktori, $namaGambar)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gambar gagal diunggah.');
        }

        $gambar = 'uploads/modul/' . $namaGambar;
    }

    
    $data = [
        'judul' => $judul,
        'slug' => $slug,
        'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
        'gambar' => $gambar,
        'urutan' => (int) $this->request->getPost('urutan'),
        'status' => 'aktif',
    ];

    try {
        $id = $this->modulModel->insert($data);

        if ($id === false) {
            if ($gambar !== null && is_file(FCPATH . $gambar)) {
                unlink(FCPATH . $gambar);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Modul gagal ditambahkan. Silakan periksa data dan coba lagi.');
        }
    } catch (\Throwable $e) {
        if ($gambar !== null && is_file(FCPATH . $gambar)) {
            unlink(FCPATH . $gambar);
        }

        log_message('error', 'Gagal menambahkan modul pelajaran: {message}', [
            'message' => $e->getMessage(),
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Modul gagal ditambahkan. Silakan coba lagi.');
    }

    return redirect()->to(site_url('admin/modul'))
        ->with('success', 'Modul berhasil ditambahkan.');

}


public function prosesEdit(int $id)
{
    $modul = $this->modulModel->find($id);

    if (!$modul) {
        return redirect()->to(site_url('admin/modul'))
            ->with('error', 'Modul tidak ditemukan.');
    }

    $rules = [
        'judul' => 'required|max_length[150]',
        'deskripsi' => 'permit_empty',
        'gambar' => 'permit_empty|is_image[gambar]|max_size[gambar,2048]|mime_in[gambar,image/jpg,image/jpeg,image/png,image/webp]',
        'urutan' => 'required|integer|greater_than_equal_to[0]',
    ];

    if (!$this->validate($rules)) {
        return redirect()->back()
            ->withInput()
            ->with('errors', $this->validator->getErrors());
    }

    $judul = trim($this->request->getPost('judul'));
    $slugDasar = url_title($judul, '-', true);

    if ($slugDasar === '') {
        return redirect()->back()
            ->withInput()
            ->with('error', 'Judul modul tidak menghasilkan slug yang valid.');
    }

    $slug = $slugDasar;
    $nomor = 1;

    while ($existing = $this->modulModel->where('slug', $slug)->first()) {
        if ((int) $existing['id'] === $id) {
            break;
        }

        $slug = $slugDasar . '-' . $nomor++;
    }

    $data = [
        'judul' => $judul,
        'slug' => $slug,
        'deskripsi' => trim((string) $this->request->getPost('deskripsi')),
        'urutan' => (int) $this->request->getPost('urutan'),
    ];

    $file = $this->request->getFile('gambar');
    $gambarLama = $modul['gambar'] ?? null;
    $gambarBaru = null;

    if ($file && $file->getError() !== UPLOAD_ERR_NO_FILE) {
        if (!$file->isValid() || $file->hasMoved()) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'File gambar tidak valid.');
        }

        $direktori = FCPATH . 'uploads/modul';

        if (!is_dir($direktori) && !mkdir($direktori, 0755, true) && !is_dir($direktori)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Folder upload gambar gagal dibuat.');
        }

        $namaGambar = $file->getRandomName();

        if (!$file->move($direktori, $namaGambar)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gambar gagal diunggah.');
        }

        $gambarBaru = 'uploads/modul/' . $namaGambar;
        $data['gambar'] = $gambarBaru;
    }

    
    try {
        $berhasil = $this->modulModel->update($id, $data);

        if (!$berhasil) {
            if ($gambarBaru !== null && is_file(FCPATH . $gambarBaru)) {
                if (!unlink(FCPATH . $gambarBaru)) {
                    log_message('error', 'Gagal membersihkan gambar baru modul setelah update gagal.');
                }
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Modul gagal diperbarui. Periksa data dan coba lagi.');
        }
    } catch (\Throwable $e) {
        if ($gambarBaru !== null && is_file(FCPATH . $gambarBaru)) {
            if (!unlink(FCPATH . $gambarBaru)) {
                log_message('error', 'Gagal membersihkan gambar baru modul setelah exception update.');
            }
        }

        log_message('error', 'Gagal memperbarui modul pelajaran: {message}', [
            'message' => $e->getMessage(),
        ]);

        return redirect()->back()
            ->withInput()
            ->with('error', 'Modul gagal diperbarui. Silakan coba lagi.');
    }

}


}
