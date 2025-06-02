<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form tambah kategori
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('','<i class="fa fa-backward"></i> Kembali',[
    'class' => 'btn btn-warning',
'onclick' => "location.href=('". site_url('kategori/index'). "')"]) ?>



<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('kategori/simpankategori') ?>
<div class="form-group">
    <label for="namakategori">Nama Kategori</label>
    <?= form_input('namakategori', '', [
        'class' => 'form-control',
        'id' => 'namakategori',
        'autofocus' => true,
        'placeholder' => 'isikan nama kategori'
    ]) ?>

    <?= session()->getFlashdata('errorNamaKategori');?>
</div>

<div class="form-group">
    <?= form_submit('', 'Simpan Kategori', [
    'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>