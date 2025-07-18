<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit kategori
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('kategori/index') . "')"
]) ?>



<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('kategori/updatekategori', '', [
    'idkategori' => $id
]) ?>
<div class="form-group">
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', $nama, [
        'class' => 'form-control',
        'id' => 'namakategori',
        'autofocus' => true,
    ]) ?>

    <?= session()->getFlashdata('errorNamaKategori'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Update Kategori', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>