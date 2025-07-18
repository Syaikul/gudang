<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Permintaan Barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
Permintaan Barang Berdasarkan WMA (Weighted Moving Average)
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= session()->getFlashdata('error') ?>
    </div>
<?php endif; ?>

<form action="<?= base_url('request/submit') ?>" method="post">
    <table class="table table-striped table-bordered" style="width:100%;" id='normal'>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th>Nama Barang</th>
                <th>Jumlah Stok</th>
                <th>Kebutuhan Stok Bulan Depan (WMA)</th>
                <th>Jumlah Permintaan</th>
                <th style="width: 10%;">Pilih</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barangList as $i => $barang): ?>

                <?php
                $isStokKurang = $barang['brgstok'] < $barang['wma'];
                $rowClass = $isStokKurang ? 'table-danger' : 'table-success';
                ?>
                <tr class="<?= $rowClass ?>">

                    <td><?= $i + 1 ?></td>
                    <td><?= esc($barang['brgnama']) ?></td>
                    <td><?= esc($barang['brgstok']) ?></td>
                    <td>
                        <?= esc($barang['wma']) ?>
                        <?php if ($isStokKurang): ?>
                            <span class="badge bg-danger">Butuh</span>
                        <?php else: ?>
                            <span class="badge bg-success">Cukup</span>
                        <?php endif; ?>
                    </td>

                    <td>
                        <?php $defaultJumlah = ($barang['brgstok'] >= $barang['wma']) ? 0 : $barang['wma']; ?>
                        <input
                            type="number"
                            name="jumlah[<?= esc($barang['brgkode']) ?>]"
                            value="<?= esc($defaultJumlah) ?>"
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
        <button type=" submit" class="btn btn-primary">Buat Permintaan</button>
    </div>

</form>

<?= $this->endSection() ?>