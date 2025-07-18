<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Data Masuk
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('kategori/index') . "')"
]) ?>
<?= $this->endSection() ?>
<?= $this->section('isi') ?>

<form action="/masuk/updatemasuk" method="post">
    <?= csrf_field(); ?>
    <input type="hidden" name="mskkode" value="<?= $dataMasuk['mskkode']; ?>">

    <div class="form-group row">
        <label for="namabarang" class="col-md-2 col-form-label">Nama Barang</label>
        <div class="col-md-5">
            <select class="form-control" id="namabarang" name="namabarang">
                <?php foreach ($barang as $brg): ?>
                    <option value="<?= $brg['brgkode']; ?>" <?= ($brg['brgkode'] == $dataMasuk['mskbrgkode']) ? 'selected' : ''; ?>>
                        <?= $brg['brgnama']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="jumlah" class="col-md-2 col-form-label">Jumlah Barang</label>
        <div class="col-md-5">
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?= old('jumlah', $dataMasuk['mskjumlah']); ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="tanggal" class="col-md-2 col-form-label">Tanggal Barang Masuk</label>
        <div class="col-md-5">
            <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?= old('tanggal', $dataMasuk['msktanggal']); ?>" required>
        </div>
    </div>

    <div class="form-group row">
        <label for="keterangan" class="col-md-2 col-form-label">Keterangan</label>
        <div class="col-md-5">
            <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?= old('keterangan', $dataMasuk['mskketerangan']); ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-5 offset-md-2">
            <button type="submit" class="btn btn-primary">Perbarui</button>
        </div>
    </div>
</form>

<?= $this->endSection() ?>