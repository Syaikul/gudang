<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?php if (in_groups('admin')) : ?>
    <?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Barang', [
        'class' => 'btn btn-primary',
        'onclick' => "location.href=('" . site_url('barang/tambahbarang') . "')"
    ]) ?>
<?php endif; ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>

<table class="table table-striped table-bordered" id='tabel' style="width:100%;">
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Barang</th>
            <th>Kategori</th>
            <th>Satuan</th>
            <th>Stok</th>
            <?php if (in_groups('admin')) : ?>
                <th style="width: 15%;">Aksi</th>
            <?php endif; ?>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($tampildata)) : ?>
            <?php $nomor = 1;
            foreach ($tampildata as $row): ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $row['brgnama']; ?></td>
                    <td><?= $row['katnama']; ?></td>
                    <td><?= $row['satnama']; ?></td>
                    <td><?= number_format($row['brgstok'], 0); ?></td>
                    <?php if (in_groups('admin')) : ?>
                        <td>
                            <button type="button" class="btn btn-info" title="Edit barang" onclick="edit('<?= $row['brgkode'] ?>')">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-danger" title="Hapus Barang" onclick="hapus('<?= $row['brgkode'] ?>')">
                                <i class="fa fa-trash-alt"></i>
                            </button>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach ?>
        <?php else : ?>
            <tr>
                <td colspan="6" class="text-center">Tidak ada data barang.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>
<script>
    function edit(id) {
        window.location = "<?= site_url('barang/editbarang') ?>/" + id;
    }

    function hapus(id) {
        pesan = confirm('Apakah anda yakin ingin menghapus barang ini?');
        if (pesan) {
            window.location = "<?= site_url('barang/hapusbarang') ?>/" + id;
        }
    }
</script>
<?= $this->endSection() ?>