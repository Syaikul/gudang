<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Modelsatuan;
use Config\Services;

class Satuan extends BaseController
{
    protected $satuan;
    public function __construct()
    {
        $this->satuan = new Modelsatuan();
    }

    public function index()
    {
        $data = [
            'tampildata' => $this->satuan->findAll()
        ];
        return view('satuan/viewsatuan', $data);
    }

    public function tambahsatuan()
    {
        return view('satuan/tambahsatuan');
    }

    public function simpansatuan()
    {
        $namasatuan = $this->request->getVar('namasatuan');
        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namasatuan' => [
                'rules' => 'required',
                'label' => 'Nama Satuan',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<br><div class="alert alert-danger">' . $validation->getError('namasatuan') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/tambahsatuan');
        } else {
            $this->satuan->insert([
                'satnama' => $namasatuan
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success"> Data satuan berhasil ditambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function editsatuan($id)
    {
        $rowData = $this->satuan->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['satnama']
            ];

            return view('satuan/editsatuan', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updatesatuan()
    {
        $idsatuan = $this->request->getVar('idsatuan');
        $namasatuan = $this->request->getVar('namasatuan');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namasatuan' => [
                'rules' => 'required',
                'label' => 'Nama Satuan',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);
        if (!$valid) {
            $pesan = [
                'errorNamaSatuan' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('namasatuan') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/editsatuan/' . $idsatuan);
        } else {
            $this->satuan->update($idsatuan, [
                'satnama' => $namasatuan
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Satuan berhasil ditambahkan
                </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        }
    }

    public function hapussatuan($id)
    {
        $rowData = $this->satuan->find($id);
        if ($rowData) {
            $this->satuan->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Satuan berhasil dihapus
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/satuan/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}
