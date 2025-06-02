<?php
echo '<pre>';
print_r($dataKeluar);
echo '</pre>';
?>

<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Data Keluar
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('keluar/index') . "')"
]) ?>
<?= $this->endSection() ?>
<?= $this->section('isi') ?>
<form action="<?= base_url('/keluar/updatekeluar') ?>" method="post">
    <?= csrf_field(); ?>
    <input type="hidden" name="klrkode" value="<?= esc($dataKeluar['klrkode']) ?>">




    <div class="form-group row">
        <label for="namabarang" class="col-md-2 col-form-label">Nama Barang</label>
        <div class="col-md-5">
            <select name="namabarang" id="namabarang" class="form-control" required>
                <option value="">Pilih Barang</option>
                <?php foreach ($barang as $row) : ?>
                    <option value="<?= esc($row['brgkode']) ?>" <?= ($row['brgkode'] == $dataKeluar['klrbrgkode']) ? 'selected' : '' ?>>
                        <?= esc($row['brgnama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="clientid" class="col-md-2 col-form-label">Client</label>
        <div class="col-md-5">
            <select name="clientid" id="clientid" class="form-control" required>
                <option value="">Pilih Client</option>
                <?php foreach ($client as $c) : ?>
                    <option value="<?= esc($c['clientid']) ?>" <?= ($c['clientid'] == $dataKeluar['clientid']) ? 'selected' : '' ?>>
                        <?= esc($c['clientnama']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="jumlah" class="col-md-2 col-form-label">Jumlah Barang</label>
        <div class="col-md-5">
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= esc($dataKeluar['klrjumlah']) ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="tanggal" class="col-md-2 col-form-label">Tanggal Barang Keluar</label>
        <div class="col-md-5">
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= esc(date('Y-m-d', strtotime($dataKeluar['klrtanggal']))) ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
        <div class="col-md-5">
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= esc($dataKeluar['klrketerangan']) ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5 offset-md-2">
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>