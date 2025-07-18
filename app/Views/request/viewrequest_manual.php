<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Permintaan Barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
Permintaan Barang non Prediktif
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('requestmanual/submit') ?>" method="post">
    <table class="table table-striped table-bordered" style="width:100%;" id='normal'>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Nama Barang</th>
                <th>Stok Sekarang</th>
                <th>Jumlah Minimal</th>
                <th>Jumlah Permintaan</th>
                <th style="width: 10%;">Pilih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barangList as $i => $barang): ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= esc($barang['brgnama']) ?></td>
                    <td><?= esc($barang['brgstok']) ?></td>
                    <td><?= esc($barang['jumlah_minimal']) ?></td>
                    <td>
                        <input
                            type="number"
                            name="jumlah[<?= esc($barang['brgkode']) ?>]"
                            value="0"
                            min="0"
                            class="form-control">
                    </td>
                    <td class="text-center">
                        <input
                            type="checkbox"
                            name="pilih[]"
                            value="<?= esc($barang['brgkode']) ?>">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-primary">Buat Permintaan</button>
    </div>
</form>

<?= $this->endSection() ?>