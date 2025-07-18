<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modellevel;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class Level extends BaseController
{
    protected $level;
    public function __construct()
    {
        $this->level = new Modellevel();
    }

    public function index()
    {
        $data = [
            'tampildata' => $this->level->findAll()
        ];
        return view('level/viewlevel', $data);
    }

    public function tambahlevel()
    {
        return view('level/tambahlevel');
    }

    public function simpanlevel()
    {
        $namalevel = $this->request->getVar('namalevel');
        $angka = $this->request->getVar('angka');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namalevel' => [
                'rules' => 'required',
                'label' => 'Nama Level',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ],
            'angka' => [
                'rules' => 'required|numeric',
                'label' => 'Angka Level',
                'errors' => [
                    'required' => '{field} tidak bisa kosong',
                    'numeric'  => '{field} harus berupa angka'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaLevel' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('namalevel') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>',
                'errorAngkaLevel' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('angka') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>',
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/level/tambahlevel');
        } else {
            $this->level->insert([
                'levelnama' => $namalevel,
                'level' => $angka
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success"> Data Level berhasil ditambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/level/index');
        }
    }


    public function editlevel($id)
    {
        $rowData = $this->level->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['levelnama'],
                'angka' => $rowData['level']
            ];

            return view('level/editlevel', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }


    public function updatelevel()
    {
        $idlevel = $this->request->getVar('idlevel');
        $namalevel = $this->request->getVar('namalevel');
        $angka = $this->request->getVar('angka');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namalevel' => [
                'rules' => 'required',
                'label' => 'Nama Level',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ],
            'angka' => [
                'rules' => 'required|numeric',
                'label' => 'Angka Level',
                'errors' => [
                    'required' => '{field} tidak bisa kosong',
                    'numeric'  => '{field} harus berupa angka'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaLevel' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('namalevel') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>',
                'errorAngkaLevel' => '<br><div class="alert alert-danger alert-dismissible">' . $validation->getError('angka') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>',
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/level/editlevel/' . $idlevel);
        } else {
            $this->level->update($idlevel, [
                'levelnama' => $namalevel,
                'level' => $angka
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                Level berhasil diperbarui
            </div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/level/index');
        }
    }


    public function hapuslevel($id)
    {
        $rowData = $this->level->find($id);
        if ($rowData) {
            $this->level->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Level berhasil dihapus
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/level/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}
