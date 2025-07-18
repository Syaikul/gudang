<?php var_dump($barang); ?>
<?php print_r($barang); ?>


<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Tambah Barang Masuk
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('masuk/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<?php if (session()->getFlashdata('error')) : ?>
    <?= session()->getFlashdata('error') ?>
<?php endif; ?>

<?php if (session()->getFlashdata('sukses')) : ?>
    <?= session()->getFlashdata('sukses') ?>
<?php endif; ?>

<form action="<?= base_url('/masuk/simpanmasuk') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group row">
        <label for="namabarang" class="col-md-2 col-form-label">Nama Barang</label>
        <div class="col-md-5">
            <select name="namabarang" id="namabarang" class="form-control" required>
                <option value="">Pilih Barang</option>
                <?php foreach ($barang as $row) : ?>
                    <?php if (isset($row['brgkode'], $row['brgnama'])) : ?>
                        <option value="<?= esc($row['brgkode']) ?>"><?= esc($row['brgnama']) ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>

            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="jumlah" class="col-md-2 col-form-label">Jumlah Barang</label>
        <div class="col-md-5">
            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="tanggal" class="col-md-2 col-form-label">Tanggal Barang Masuk</label>
        <div class="col-md-5">
            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
        <div class="col-md-5">
            <input type="text" class="form-control" id="keterangan" name="keterangan">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5 offset-md-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>