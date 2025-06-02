<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'main::index');


$routes->get('kategori/index', 'Kategori::index');
$routes->get('kategori/tambahkategori', 'Kategori::tambahkategori');
$routes->post('kategori/simpankategori', 'Kategori::simpankategori');

$routes->get('kategori/editkategori/(:num)', 'Kategori::editkategori/$1');
$routes->post('kategori/updatekategori', 'Kategori::updatekategori');

$routes->get('kategori/hapuskategori/(:num)', 'Kategori::hapuskategori/$1');



$routes->get('satuan/index', 'Satuan::index');
$routes->get('satuan/tambahsatuan', 'satuan::tambahsatuan');
$routes->post('satuan/simpansatuan', 'satuan::simpansatuan');

$routes->get('satuan/editsatuan/(:num)', 'Satuan::editsatuan/$1');
$routes->post('satuan/updatesatuan', 'Satuan::updatesatuan');
$routes->get('satuan/hapussatuan/(:num)', 'Satuan::hapussatuan/$1');


$routes->get('barang/index', 'Barang::index');
$routes->post('barang/index', 'Barang::index');

$routes->get('barang/tambahbarang', 'Barang::tambahbarang');
$routes->post('barang/simpanbarang', 'Barang::simpanbarang');


$routes->get('barang/editbarang/(:any)', 'Barang::editbarang/$1');

$routes->get('barang/hapusbarang/(:any)', 'Barang::hapusbarang/$1');

$routes->post('barang/updatebarang', 'Barang::updatebarang');


$routes->get('client/index', 'Client::index');
$routes->get('client/tambahclient', 'Client::tambahclient');
$routes->post('client/simpanclient', 'Client::simpanclient');

$routes->get('client/editclient/(:num)', 'Client::editclient/$1');
$routes->post('client/updateclient', 'Client::updateclient');

$routes->get('client/hapusclient/(:num)', 'Client::hapusclient/$1');


// $routes->get('masuk/index', 'Masuk::index');
// $routes->post('masuk/updatemasuk', 'Masuk::updatemasuk');

// $routes->get('masuk/tambahmasuk', 'Masuk::tambahmasuk'); // Halaman tambah barang masuk
// $routes->get('masuk/editmasuk/(:num)', 'Masuk::editmasuk/$1'); // Halaman edit berdasarkan ID
// $routes->post('masuk/updatemasuk', 'Masuk::updatemasuk'); // Proses update data

// $routes->post('masuk/simpanmasuk', 'Masuk::simpanmasuk');

// $routes->get('masuk/hapusmasuk/(:num)', 'Masuk::hapusmasuk/$1');



$routes->get('masuk/index', 'Masuk::index');
$routes->get('masuk', 'Masuk::index');


$routes->get('masuk/tambahmasuk', 'Masuk::tambahmasuk');
$routes->post('masuk/simpanmasuk', 'Masuk::simpanmasuk');

$routes->get('masuk/editmasuk/(:num)', 'Masuk::editmasuk/$1');
$routes->post('masuk/updatemasuk', 'Masuk::updatemasuk');
$routes->get('masuk/hapusmasuk/(:num)', 'Masuk::hapusmasuk/$1');


$routes->get('keluar/index', 'Keluar::index');
$routes->get('keluar', 'Keluar::index');
$routes->get('keluar/tambahkeluar', 'Keluar::tambahkeluar');

$routes->post('keluar/simpankeluar', 'Keluar::simpankeluar');


$routes->get('keluar/editkeluar/(:num)', 'Keluar::editkeluar/$1');

$routes->post('keluar/updatekeluar', 'Keluar::updatekeluar');
$routes->get('keluar/hapuskeluar/(:num)', 'Keluar::hapuskeluar/$1');

$routes->get('request', 'Request::index');
$routes->get('request/index', 'Request::index');
$routes->post('request/submit', 'Request::submit');


$routes->get('biaya/index', 'Biaya::index');
$routes->get('biaya', 'Biaya::index');
$routes->post('biaya/cetak', 'Biaya::cetak');
