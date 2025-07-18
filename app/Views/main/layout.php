<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Blank Page</title>
    <link rel="icon" href="<?= base_url() ?>/dist/img/Logoicon.png" type="image/png">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="<?= base_url() ?>/plugins/fontawesome-free/css/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>/dist/css/adminlte.min.css">
    <!-- datatable
    <link rel="stylesheet" href="https://cdn.datatables.net/2.3.1/css/dataTables.dataTables.css"> -->
    <link href="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.css" rel="stylesheet" crossorigin="anonymous">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class=" main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="https://www.mesitechmitra.co.id" class="brand-link">
                <img src="<?= base_url() ?>/dist/img/Logoicon.png" alt="AdminLTE Logo"
                    class="brand-image" style="opacity: .8">
                <span class="brand-text font-weight-light">MESITECHMITRA</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <!-- <div class="image">
                        <img src="<?= base_url() ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                            alt="User Image">
                    </div> -->
                    <div class="info ">
                        <a class="d-block" style="padding-left: 40px;">
                            <?= user()->username; ?>
                        </a>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->
                        <!-- home -->
                        <li class="nav-item">
                            <a href="<?= site_url('/'); ?>" class="nav-link">
                                <i class="fa-solid fa-house mr-3"></i>
                                <p class="text">Menu Utama</p>
                            </a>
                        </li>
                        <!-- Data Master -->
                        <?php if (in_groups('admin')) : ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-gauge-high mr-3"></i>
                                    <p>
                                        Data Master
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-4">
                                    <li class="nav-item">
                                        <a href="<?= site_url('kategori/index'); ?>" class="nav-link">
                                            <i class="fa-solid fa-list mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                            <p class="text">Kategori</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= site_url('satuan/index'); ?>" class="nav-link">
                                            <i class="fa-solid fa-cart-flatbed mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                            <p class="text">Satuan</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= site_url('client/index'); ?>" class="nav-link">
                                            <i class="fa-solid fa-user-tie mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                            <p class="text">Client</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= site_url('level/index'); ?>" class="nav-link">
                                            <i class="fa-solid fa-chart-bar mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                            <p class="text">Level</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <!-- Manajemen Stock -->
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-bars-progress mr-3"></i>
                                <p>
                                    Manajemen Stok
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-4">
                                <li class="nav-item">
                                    <a href="<?= site_url('barang/index'); ?>" class="nav-link">
                                        <i class="fa-solid fa-boxes-stacked mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                        <p class="text">Data Barang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= site_url('masuk/index'); ?>" class="nav-link">
                                        <i class="fa-solid fa-inbox mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                        <p class="text">Barang Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= site_url('keluar/index'); ?>" class="nav-link">
                                        <i class="fa-solid fa-outdent mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                        <p class="text">Barang Keluar</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Permintaan dan Biaya -->
                        <?php if (in_groups('admin') || in_groups('manager')) : ?>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa-solid fa-scroll mr-3"></i>
                                    <p>
                                        Permintaan & Biaya
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview pl-4">
                                    <?php if (in_groups('admin')) : ?>
                                        <li class="nav-item">
                                            <a href="<?= site_url('request/index'); ?>" class="nav-link">
                                                <i class="fa-solid fa-receipt mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                                <p class="text">Request Barang Active</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="<?= site_url('requestmanual/index'); ?>" class="nav-link">
                                                <i class="fa-solid fa-receipt mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                                <p class="text">Request Barang Passive</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    <?php if (in_groups('admin') || in_groups('manager')) : ?>
                                        <li class="nav-item">
                                            <a href="<?= site_url('biaya/index'); ?>" class="nav-link">
                                                <i class="fa-solid fa-credit-card mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                                <p class="text">Ringkasan Biaya</p>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </li>
                        <?php endif; ?>



                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-user mr-3"></i>
                                <p>
                                    Akun Pengguna
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview pl-4">
                                <?php if (in_groups('admin')) : ?>
                                    <li class="nav-item">
                                        <a href="<?= site_url('user/index'); ?>" class="nav-link">
                                            <i class="fa-solid fa-users-viewfinder mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                            <p class="text">User List</p>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li class="nav-item">
                                    <a href="<?= site_url('/logout'); ?>" class="nav-link">
                                        <i class="fa-solid fa-right-from-bracket mr-2" style="width: 20px; display: inline-block; text-align: center;"></i>
                                        <p class="text">Logout</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>
                                <?= $this->renderSection('judul') ?>
                            </h1>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            <?= $this->renderSection('subjudul') ?>
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <?= $this->renderSection('isi') ?>
                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">

            <strong>Copyright &copy; 2025
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="<?= base_url() ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="<?= base_url() ?>/dist/js/demo.js"></script>


    <!-- JS PDFMake (untuk export PDF) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js" crossorigin="anonymous"></script>

    <!-- JS DataTables Bootstrap 4 + Buttons -->
    <script src="https://cdn.datatables.net/v/bs4/jq-3.7.0/jszip-3.10.1/dt-2.3.1/b-3.2.3/b-colvis-3.2.3/b-html5-3.2.3/b-print-3.2.3/datatables.min.js" crossorigin="anonymous"></script>
    <!-- Inisialisasi DataTable -->
    <script>
        $(document).ready(function() {
            // Konfigurasi untuk #tabel (dengan tombol export)
            $('#tabel').DataTable({
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: "<'top-row mb-3'B>" +
                    "<'second-row d-flex justify-content-between mb-3'<'length'l><'search'f>>" +
                    "rtip",
                buttons: [{
                        extend: 'copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis'
                    }
                ]
            });

            // Konfigurasi untuk #tabel2 (hanya entries per page & search)
            $('#normal').DataTable({
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: "<'second-row d-flex justify-content-between mb-3'<'length'l><'search'f>>rtip"

            });
        });
    </script>


</body>

</html>