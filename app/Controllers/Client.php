<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Modelclient;

class Client extends BaseController
{
    protected $client;

    public function __construct()
    {
        $this->client = new Modelclient();
    }

    public function index()
    {
        $data = [
            'tampildata' => $this->client->findAll()
        ];
        return view('client/viewclient', $data);
    }

    public function tambahclient()
    {
        return view('client/tambahclient');
    }

    public function simpanclient()
    {
        $namaclient = $this->request->getVar('namaclient');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namaclient' => [
                'rules' => 'required',
                'label' => 'Nama Client',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaClient' => '<div class="alert alert-danger alert-dismissible">' . $validation->getError('namaclient') . '<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button></div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/client/tambahclient');
        } else {
            $this->client->insert([
                'clientnama' => $namaclient
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success"> Data Client berhasil ditambahkan...</div>'
            ];

            session()->setFlashdata($pesan);
            return redirect()->to('/client/index');
        }
    }

    public function editclient($id)
    {
        $rowData = $this->client->find($id);

        if ($rowData) {
            $data = [
                'id' => $id,
                'nama' => $rowData['clientnama']
            ];

            return view('client/editclient', $data);
        } else {
            exit('Data tidak ditemukan');
        }
    }

    public function updateclient()
    {
        $idclient = $this->request->getVar('idclient');
        $namaclient = $this->request->getVar('namaclient');

        $validation = \Config\Services::validation();
        $valid = $this->validate([
            'namaclient' => [
                'rules' => 'required',
                'label' => 'Nama Client',
                'errors' => [
                    'required' => '{field} tidak bisa kosong'
                ]
            ]
        ]);

        if (!$valid) {
            $pesan = [
                'errorNamaClient' => '<div class="alert alert-danger alert-dismissible">' . $validation->getError('namaclient') . '</div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/client/editclient/' . $idclient);
        } else {
            $this->client->update($idclient, [
                'clientnama' => $namaclient
            ]);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Client berhasil perbarui
                </div>'
            ];
            session()->setFlashdata($pesan);
            return redirect()->to('/client/index');
        }
    }

    public function hapusclient($id)
    {
        $rowData = $this->client->find($id);
        if ($rowData) {
            $this->client->delete($id);

            $pesan = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  Client berhasil dihapus
                </div>'
            ];
            session()->setFlashdata($pesan);

            return redirect()->to('/client/index');
        } else {
            exit('Data tidak ditemukan');
        }
    }
}
