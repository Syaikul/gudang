<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Barang Keluar
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?php if (in_groups('admin')) : ?>

    <form action="<?= base_url('keluar/importExcel') ?>" method="post" enctype="multipart/form-data">
        <label>Upload File Excel (.xlsx / .csv)</label><br>
        <input type="file" name="fileexcel" accept=".xls,.xlsx,.csv" required>
        <button type="submit" class='btn btn-primary'>Import</button>
    </form>

    <br>
    <?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Satu Data', [
        'class' => 'btn btn-primary',
        'onclick' => "location.href=('" . site_url('keluar/tambahkeluar') . "')"
    ]) ?>

<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<?php if (session()->getFlashdata('error')) : ?>
    <?= session()->getFlashdata('error') ?>
<?php endif; ?>


<?php if (session()->getFlashdata('sukses')) : ?>
    <?= session()->getFlashdata('sukses') ?>
<?php endif; ?>

<!-- untuk notif excel -->
<?php if (session()->getFlashdata('sukses_excel')) : ?>
    <div class="alert alert-success"><?= session()->getFlashdata('sukses_excel') ?></div>
<?php endif; ?>

<?php if (session()->getFlashdata('gagal_excel')) : ?>
    <div class="alert alert-warning"><?= session()->getFlashdata('gagal_excel') ?></div>
<?php endif; ?>


<table class="table table-striped table-bordered" style="width:100%;" id="tabel">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Barang</th>
            <th>Jumlah Barang Keluar</th>
            <th>Tanggal Keluar</th>
            <th>Client</th>
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
                    <td><?= esc($row['klrjumlah']) ?></td>
                    <td><?= date('d-m-Y', strtotime($row['klrtanggal'])) ?></td>
                    <td><?= esc($row['clientnama']) ?></td>
                    <?php if (in_groups('admin')) : ?>
                        <td>
                            <button type="button" class="btn btn-info" title="Edit Keluar" onclick="edit('<?= $row['klrkode'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" title="Hapus Keluar" onclick="hapus('<?= $row['klrkode'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    <?php endif; ?>

                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data barang keluar.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script>
    function edit(id) {
        window.location = "<?= site_url('keluar/editkeluar') ?>/" + id;
    }

    function hapus(id) {
        if (confirm('Apakah Anda yakin ingin menghapus barang keluar ini?')) {
            window.location = "<?= site_url('keluar/hapuskeluar') ?>/" + id;
        }
    }
</script>
<?= $this->endSection() ?>