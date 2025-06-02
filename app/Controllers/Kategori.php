<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelkategori;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Kategori extends BaseController
{
    protected $kategori;
    public function __construct()
    {
        $this->kategori = new Modelkategori();
    }

    public function index()
    {
        $data = [
            'tampildata' => $this->kategori->findAll()
        ];
        return view('kategori/viewkategori', $data);
    }

    public function tambahkategori()
    {
        return view('kategori/tambahkategori');
    }

    public function simpankategori()
    {
        $namakategori = $this->request->getVar('namakategori');
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namakategori' => [
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('namakategori') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/tambahkategori');
        } else {
            $this->kategori->insert([
                'katnama' => $namakategori
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success"> Data Kategori berhasil ditambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }

    public function editkategori($id)
    {
        $rowData = $this->kategori->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['katnama']
            ];

            return view('kategori/editkategori', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatekategori()
    {
        $idkategori = $this->request->getVar('idkategori');
        $namakategori = $this->request->getVar('namakategori');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namakategori' => [
                'rules' => 'required',
                'label' => 'Nama Kategori',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaKategori' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('namakategori') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/editkategori/' . $idkategori);
        } else {
            $this->kategori->update($idkategori, [
                'katnama' => $namakategori
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Kategori berhasil ditambahkan
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        }
    }

    public function hapuskategori($id)
    {
        $rowData = $this->kategori->find($id);
        if ($rowData) {
            $this->kategori->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Kategori berhasil dihapus
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/kategori/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}
