<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Barang Masuk
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?php if (in_groups('admin')) : ?>
    <form action="/masuk/importExcel" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="fileexcel">Pilih File Excel</label>
            <input type="file" name="fileexcel" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Import</button>
    </form>
    <br>

    <?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
        'class' => 'btn btn-primary',
        'onclick' => "location.href=('" . site_url('masuk/tambahmasuk') . "')"
    ]) ?>
<?php endif; ?>
<?= $this->endSection() ?>


<?= $this->section('isi') ?>
<?= session()->getFlashdata('sukses'); ?>
<!-- untuk notif excel -->
<?php if (session()->getFlashdata('sukses_excel')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('sukses_excel') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('gagal_excel')) : ?>
    <div class="alert alert-warning"><?= session()->getFlashdata('gagal_excel') ?></div>
<?php endif; ?>
<table class="table table-striped table-bordered" style="width:100%;" id='tabel'>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang Masuk</th>
            <th style="width: 15%;">Tanggal Masuk</th>
            <?php if (in_groups('admin')) : ?>
                <th style="width: 15%;">Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tampildata)) : ?>
            <?php $nomor = 1; ?>

            <?php foreach ($tampildata as $row) : ?>
                <tr>
                    <td><?= $nomor++ ?></td>
                    <td><?= esc($row['brgnama']) ?></td>
                    <td><?= esc($row['mskjumlah']) ?></td>
                    <td><?= date('d-m-Y', strtotime($row['msktanggal'])) ?></td>
                    <?php if (in_groups('admin')) : ?>
                        <td>
                            <button type="button" class="btn btn-info" title="Edit Masuk" onclick="edit('<?= $row['mskkode'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>

                            <button type="button" class="btn btn-danger" title="Hapus Masuk" onclick="hapus('<?= $row['mskkode'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>

                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5" class="text-center">Tidak ada data barang masuk.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    function edit(id) {
        window.location = "<?= site_url('masuk/editmasuk') ?>/" + id;
    }


    function hapus(id) {
        var pesan = confirm('Apakah Anda yakin ingin menghapus barang masuk ini?');
        if (pesan) {

            window.location = "<?= site_url('masuk/hapusmasuk') ?>/" + id;

        } else {
            return false;
        }
    }
</script>
<?= $this->endSection() ?>