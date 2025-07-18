<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form tambah barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('barang/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open_multipart('barang/simpanbarang') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>

<div class="form-group row">
    <label for="Kode Barang" class="col-md-2 col-form-label">Kode Barang</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="kodebarang" name="kodebarang">
    </div>
</div>

<div class="form-group row">
    <label for="Barang" class="col-md-2 col-form-label">Nama Barang</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="namabarang" name="namabarang">
    </div>
</div>

<div class="form-group row">
    <label for="Barang" class="col-md-2 col-form-label">Deskripsi</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="deskripsi" name="deskripsi">
    </div>
</div>

<div class="form-group row">
    <label for="kategori" class="col-md-2 col-form-label">Pilih kategori</label>
    <div class="col-md-3">
        <select name="kategori" id="kategori" class="form-control">
            <option selected value="">=Pilih=</option>
            <?php foreach ($datakategori as $kat) : ?>
                <option value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="kategori" class="col-md-2 col-form-label">Pilih Level</label>
    <div class="col-md-3">
        <select name="level" id="level" class="form-control">
            <option selected value="">=Pilih=</option>
            <?php foreach ($datalevel as $lev) : ?>
                <option value="<?= $lev['idlevel'] ?>"><?= $lev['levelnama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="Satuan" class="col-md-2 col-form-label">Pilih Satuan</label>
    <div class="col-md-3">
        <select name="satuan" id="satuan" class="form-control">
            <option selected value="">=Pilih=</option>
            <?php foreach ($datasatuan as $sat) : ?>
                <option value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="Harga" class="col-md-2 col-form-label">Harga</label>
    <div class="col-md-3">
        <input type="text" class="form-control" id="harga" name="harga">
    </div>
</div>


<div class="form-group row">
    <label for="Stok" class="col-md-2 col-form-label">Stok</label>
    <div class="col-md-3">
        <input type="text" class="form-control" id="stok" name="stok">
    </div>
</div>

<div class="form-group row">
    <label for="Upload" class="col-md-2 col-form-label">Upload Gambar <br>(<i>Jika ada...</i>)</label>
    <div class="col-md-1">
        <input type="file" id="gambar" name="gambar">
    </div>
</div>

<div class="form-group row">
    <label for="Stok" class="col-md-2 col-form-label"></label>
    <div class="col-md-3">
        <input type="submit" value="Simpan" class="btn btn-success">
    </div>
</div>
<?= form_close(); ?>


<?= $this->endSection() ?>