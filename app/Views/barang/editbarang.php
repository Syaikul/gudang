<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit barang
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('barang/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open_multipart('barang/updatebarang') ?>
<?= session()->getFlashdata('error'); ?>
<?= session()->getFlashdata('sukses'); ?>

<div class="form-group row">
    <label for="Kode Barang" class="col-md-2 col-form-label">Kode Barang</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="kodebarang" name="kodebarang" readonly value="<?= $kodebarang; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="Barang" class="col-md-2 col-form-label">Nama Barang</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="namabarang" name="namabarang" value="<?= $namabarang; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="Barang" class="col-md-2 col-form-label">Deskripsi</label>
    <div class="col-md-5">
        <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?= $deskripsi; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="kategori" class="col-md-2 col-form-label">Pilih kategori</label>
    <div class="col-md-3">
        <select name="kategori" id="kategori" class="form-control">
            <?php foreach ($datakategori as $kat) : ?>
                <?php if ($kat['katid'] == $kategori) : ?>
                    <option selected value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>

                <?php else : ?>

                    <option value="<?= $kat['katid'] ?>"><?= $kat['katnama'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="level" class="col-md-2 col-form-label">Pilih Level</label>
    <div class="col-md-3">
        <select name="level" id="level" class="form-control">
            <?php foreach ($datalevel as $lev) : ?>
                <?php if ($lev['idlevel'] == $level) : ?>
                    <option selected value="<?= $lev['idlevel'] ?>"><?= $lev['levelnama'] ?></option>

                <?php else : ?>

                    <option value="<?= $lev['idlevel'] ?>"><?= $lev['levelnama'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="Satuan" class="col-md-2 col-form-label">Pilih Satuan</label>
    <div class="col-md-3">
        <select name="satuan" id="satuan" class="form-control">
            <?php foreach ($datasatuan as $sat) : ?>
                <?php if ($sat['satid'] == $satuan) : ?>
                    <option selected value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>

                <?php else : ?>

                    <option value="<?= $sat['satid'] ?>"><?= $sat['satnama'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<div class="form-group row">
    <label for="Harga" class="col-md-2 col-form-label">Harga</label>
    <div class="col-md-3">
        <input type="text" class="form-control" id="harga" name="harga" value="<?= $harga; ?>">
    </div>
</div>


<div class="form-group row">
    <label for="Stok" class="col-md-2 col-form-label">Stok</label>
    <div class="col-md-3">
        <input type="text" class="form-control" id="stok" name="stok" value="<?= $stok; ?>">
    </div>
</div>

<div class="form-group row">
    <label for="Upload" class="col-md-2 col-form-label">Gambar yang sudah ada</label>
    <div class="col-md-3">
        <img src="<?= base_url() . '/' . $gambar ?>" class="img-thumbnail" style="width: 50%;" alt="Gambar Belum di Upload">
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