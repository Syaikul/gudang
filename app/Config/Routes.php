<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'main::index');
$routes->get('/', 'Home::index');
$routes->get('/home', 'Home::index');





$routes->get('kategori/index', 'Kategori::index', ['filter' => 'role:admin']);
$routes->get('kategori/tambahkategori', 'Kategori::tambahkategori', ['filter' => 'role:admin']);
$routes->post('kategori/simpankategori', 'Kategori::simpankategori', ['filter' => 'role:admin']);
$routes->get('kategori/editkategori/(:num)', 'Kategori::editkategori/$1', ['filter' => 'role:admin']);
$routes->post('kategori/updatekategori', 'Kategori::updatekategori', ['filter' => 'role:admin']);
$routes->get('kategori/hapuskategori/(:num)', 'Kategori::hapuskategori/$1', ['filter' => 'role:admin']);

$routes->get('satuan/index', 'Satuan::index', ['filter' => 'role:admin']);
$routes->get('satuan/tambahsatuan', 'satuan::tambahsatuan', ['filter' => 'role:admin']);
$routes->post('satuan/simpansatuan', 'satuan::simpansatuan', ['filter' => 'role:admin']);
$routes->get('satuan/editsatuan/(:num)', 'Satuan::editsatuan/$1', ['filter' => 'role:admin']);
$routes->post('satuan/updatesatuan', 'Satuan::updatesatuan', ['filter' => 'role:admin']);
$routes->get('satuan/hapussatuan/(:num)', 'Satuan::hapussatuan/$1', ['filter' => 'role:admin']);


$routes->get('client/index', 'Client::index', ['filter' => 'role:admin']);
$routes->get('client/tambahclient', 'Client::tambahclient', ['filter' => 'role:admin']);
$routes->post('client/simpanclient', 'Client::simpanclient', ['filter' => 'role:admin']);
$routes->get('client/editclient/(:num)', 'Client::editclient/$1', ['filter' => 'role:admin']);
$routes->post('client/updateclient', 'Client::updateclient', ['filter' => 'role:admin']);
$routes->get('client/hapusclient/(:num)', 'Client::hapusclient/$1', ['filter' => 'role:admin']);


$routes->get('barang/index', 'Barang::index');
$routes->post('barang/index', 'Barang::index');
$routes->get('barang/tambahbarang', 'Barang::tambahbarang', ['filter' => 'role:admin']);
$routes->post('barang/simpanbarang', 'Barang::simpanbarang', ['filter' => 'role:admin']);
$routes->get('barang/editbarang/(:any)', 'Barang::editbarang/$1', ['filter' => 'role:admin']);
$routes->get('barang/hapusbarang/(:any)', 'Barang::hapusbarang/$1', ['filter' => 'role:admin']);
$routes->post('barang/updatebarang', 'Barang::updatebarang', ['filter' => 'role:admin']);




// $routes->get('masuk/index', 'Masuk::index');
// $routes->post('masuk/updatemasuk', 'Masuk::updatemasuk');

// $routes->get('masuk/tambahmasuk', 'Masuk::tambahmasuk'); // Halaman tambah barang masuk
// $routes->get('masuk/editmasuk/(:num)', 'Masuk::editmasuk/$1'); // Halaman edit berdasarkan ID
// $routes->post('masuk/updatemasuk', 'Masuk::updatemasuk'); // Proses update data

// $routes->post('masuk/simpanmasuk', 'Masuk::simpanmasuk');

// $routes->get('masuk/hapusmasuk/(:num)', 'Masuk::hapusmasuk/$1');



$routes->get('masuk/index', 'Masuk::index');
$routes->get('masuk', 'Masuk::index');
$routes->get('masuk/tambahmasuk', 'Masuk::tambahmasuk', ['filter' => 'role:admin']);
$routes->post('masuk/simpanmasuk', 'Masuk::simpanmasuk', ['filter' => 'role:admin']);
$routes->get('masuk/editmasuk/(:num)', 'Masuk::editmasuk/$1', ['filter' => 'role:admin']);
$routes->post('masuk/updatemasuk', 'Masuk::updatemasuk', ['filter' => 'role:admin']);
$routes->get('masuk/hapusmasuk/(:num)', 'Masuk::hapusmasuk/$1', ['filter' => 'role:admin']);


$routes->get('keluar/index', 'Keluar::index');
$routes->get('keluar', 'Keluar::index');
$routes->get('keluar/tambahkeluar', 'Keluar::tambahkeluar', ['filter' => 'role:admin']);
$routes->post('keluar/simpankeluar', 'Keluar::simpankeluar', ['filter' => 'role:admin']);
$routes->get('keluar/editkeluar/(:num)', 'Keluar::editkeluar/$1', ['filter' => 'role:admin']);
$routes->post('keluar/updatekeluar', 'Keluar::updatekeluar', ['filter' => 'role:admin']);
$routes->get('keluar/hapuskeluar/(:num)', 'Keluar::hapuskeluar/$1', ['filter' => 'role:admin']);

$routes->get('request', 'Request::index', ['filter' => 'role:admin']);
$routes->get('request/index', 'Request::index', ['filter' => 'role:admin']);
$routes->post('request/submit', 'Request::submit', ['filter' => 'role:admin']);


$routes->get('biaya/index', 'Biaya::index', ['filter' => 'role:admin,manager']);
$routes->get('biaya', 'Biaya::index', ['filter' => 'role:admin,manager']);
$routes->post('biaya/cetak', 'Biaya::cetak', ['filter' => 'role:admin,manager']);

$routes->get('user/index', 'User::index', ['filter' => 'role:admin']);
$routes->get('user', 'User::index', ['filter' => 'role:admin']);
$routes->post('user/update', 'User::update', ['filter' => 'role:admin']);
