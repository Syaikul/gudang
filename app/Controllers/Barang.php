<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\Modelbarang;
use App\Models\Modelkategori;
use App\Models\Modelsatuan;
use App\Models\Modellevel;


class Barang extends BaseController
{
    protected $barang;
    public function __construct()
    {
        $this->barang = new Modelbarang();
    }
    public function index()
    {
        $dataBarang = $this->barang->tampildata()->findAll();

        $data = [
            'tampildata' => $dataBarang
        ];

        return view('barang/viewbarang', $data);
    }



    public function tambahbarang()
    {
        $modelkategori = new Modelkategori();
        $modelsatuan = new Modelsatuan();
        $modellevel = new Modellevel();

        $data = [
            'datakategori' => $modelkategori->findAll(),
            'datasatuan' => $modelsatuan->findAll(),
            'datalevel' => $modellevel->findAll()

        ];
        return view('barang/tambahbarang', $data);
    }

    public function simpanbarang()
    {
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $deskripsi = $this->request->getVar('deskripsi');
        $kategori   = $this->request->getVar('kategori');
        $level   = $this->request->getVar('level');
        $satuan     = $this->request->getVar('satuan');
        $harga      = $this->request->getVar('harga');
        $stok       = $this->request->getVar('stok');



        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'kodebarang' => [
                'rules'  => 'required|is_unique[barang.brgkode]',
                'label'  => 'Kode Barang',
                'errors' => [
                    'required'  => '{field} tidak boleh kosong',
                    'is_unique' => '{field} sudah ada...'
                ]
            ],
            'namabarang' => [
                'rules'  => 'required',
                'label'  => 'Nama Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'label'  => 'deskripsi',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],

            'kategori' => [
                'rules'  => 'required',
                'label'  => 'Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'level' => [
                'rules'  => 'required',
                'label'  => 'Level',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'satuan' => [
                'rules'  => 'required',
                'label'  => 'Satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'label'  => 'Harga',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya dalam bentuk angka'
                ]
            ],
            'stok' => [
                'rules'  => 'required|numeric',
                'label'  => 'Stok',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya dalam bentuk angka'
                ]
            ],
            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'Gambar',
            ]
        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5></h5>'
                    . $validation->listErrors() .
                    '</div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('barang/tambahbarang');
        } else {
            $gambar = $_FILES['gambar']['name'];

            if ($gambar != NULL) {
                $namaFileGambar = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                $pathGambar = 'upload/' . $fileGambar->getName();
            } else {
                $pathGambar = '';
            }

            $this->barang->insert([
                'brgkode' => $kodebarang,
                'brgnama' => $namabarang,
                'brgdeskripsi' => $deskripsi,
                'brgkatid' => $kategori,
                'brglevel' => $level,
                'brgsatid' => $satuan,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);

            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5></h5>
                  <strong>' . $namabarang . '</strong> Berhasil ditambahkan
                </div>'
            ];

            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        }
    }

    public function editbarang($kode)
    {
        $cekdata = $this->barang->find($kode);

        if ($cekdata) {
            $modelkategori = new Modelkategori();
            $modelsatuan = new Modelsatuan();
            $modellevel = new Modellevel();

            $data = [
                'kodebarang' => $cekdata['brgkode'],
                'namabarang' => $cekdata['brgnama'],
                'deskripsi' => $cekdata['brgdeskripsi'],
                'kategori' => $cekdata['brgkatid'],
                'level' => $cekdata['brglevel'],
                'satuan' => $cekdata['brgsatid'],
                'harga' => $cekdata['brgharga'],
                'stok' => $cekdata['brgstok'],
                'datakategori' => $modelkategori->findAll(),
                'datalevel' => $modellevel->findAll(),
                'datasatuan' => $modelsatuan->findAll(),
                'gambar' => $cekdata['brggambar']
            ];
            return view('barang/editbarang', $data);
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h5><i class="icon fas fa-ban"></i> Error!</h5>
                  data barang tidak ditemukan
                </div>'
            ];

            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/tambahbarang');
        }
    }
    public function updatebarang()
    {
        $kodebarang = $this->request->getVar('kodebarang');
        $namabarang = $this->request->getVar('namabarang');
        $deskripsi = $this->request->getVar('deskripsi');
        $kategori   = $this->request->getVar('kategori');
        $level   = $this->request->getVar('level');
        $satuan     = $this->request->getVar('satuan');
        $harga      = $this->request->getVar('harga');
        $stok       = $this->request->getVar('stok');

        $validation = \Config\Services::validation();

        $valid = $this->validate([
            'namabarang' => [
                'rules'  => 'required',
                'label'  => 'Nama Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'deskripsi' => [
                'rules'  => 'required',
                'label'  => 'Nama Barang',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'kategori' => [
                'rules'  => 'required',
                'label'  => 'Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'level' => [
                'rules'  => 'required',
                'label'  => 'Kategori',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'satuan' => [
                'rules'  => 'required',
                'label'  => 'Satuan',
                'errors' => [
                    'required' => '{field} tidak boleh kosong'
                ]
            ],
            'harga' => [
                'rules'  => 'required|numeric',
                'label'  => 'Harga',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya dalam bentuk angka'
                ]
            ],
            'stok' => [
                'rules'  => 'required|numeric',
                'label'  => 'Stok',
                'errors' => [
                    'required' => '{field} tidak boleh kosong',
                    'numeric'  => '{field} hanya dalam bentuk angka'
                ]
            ],
            'gambar' => [
                'rules' => 'mime_in[gambar,image/png,image/jpg,image/jpeg]|ext_in[gambar,png,jpg,jpeg]',
                'label' => 'Gambar',
            ]
        ]);

        if (!$valid) {
            $sess_Pesan = [
                'error' => '<div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <h5></h5>'
                    . $validation->listErrors() .
                    '</div>'
            ];

            session()->setFlashdata($sess_Pesan);
            return redirect()->to('/barang/editbarang/' . $kodebarang);
        } else {
            // Ambil data barang untuk mendapatkan path gambar lama
            $cekdata = $this->barang->find($kodebarang);
            $pathGambarLama = $cekdata['brggambar']; // Ini yang kamu lupa definisikan sebelumnya
            $gambar = $_FILES['gambar']['name'];

            // Cek apakah gambar baru diupload
            if ($gambar != NULL) {
                // Jika ada gambar lama, hapus gambar lama
                if (file_exists($pathGambarLama) && $pathGambarLama != '') {
                    unlink($pathGambarLama);
                }

                // Upload gambar baru
                $namaFileGambar = $kodebarang;
                $fileGambar = $this->request->getFile('gambar');
                $fileGambar->move('upload', $namaFileGambar . '.' . $fileGambar->getExtension());

                // Update path gambar baru
                $pathGambar = 'upload/' . $fileGambar->getName();
            } else {
                // Jika gambar tidak diganti, biarkan pathGambar tetap seperti sebelumnya
                $pathGambar = $pathGambarLama;
            }

            // Update data barang
            $this->barang->update($kodebarang, [
                'brgnama' => $namabarang,
                'brgdeskripsi' => $deskripsi,
                'brgkatid' => $kategori,
                'brgsatid' => $satuan,
                'brglevel' => $level,
                'brgharga' => $harga,
                'brgstok' => $stok,
                'brggambar' => $pathGambar
            ]);

            // Pesan sukses
            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5></h5>
              data <strong>' . $namabarang . '</strong> Berhasil diperbarui
            </div>'
            ];

            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        }
    }

    public function hapusbarang($kode)
    {
        $cekdata = $this->barang->find($kode);

        if ($cekdata) {

            $namabarang = $cekdata['brgnama'];
            $pathGambarLama = $cekdata['brggambar'];


            if (!empty($pathGambarLama) && file_exists($pathGambarLama)) {
                unlink($pathGambarLama);
            }

            // Hapus data barang dari database
            $this->barang->delete($kode);


            $pesan_sukses = [
                'sukses' => '<div class="alert alert-success alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5></h5>
              <strong>' . $namabarang . '</strong> Berhasil dihapus
            </div>'
            ];

            session()->setFlashdata($pesan_sukses);
            return redirect()->to('/barang/index');
        } else {
            $pesan_error = [
                'error' => '<div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <h5></h5>
              data barang tidak ditemukan
            </div>'
            ];

            session()->setFlashdata($pesan_error);
            return redirect()->to('/barang/index');
        }
    }
}
