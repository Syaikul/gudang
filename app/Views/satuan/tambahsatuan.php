<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form tambah Satuan
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('','<i class="fa fa-backward"></i> Kembali',[
    'class' => 'btn btn-warning',
'onclick' => "location.href=('". site_url('satuan/index'). "')"]) ?>



<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('satuan/simpansatuan') ?>
<div class="form-group">
    <label for="namasatuan">Nama Satuan</label>
    <?= form_input('namasatuan', '', [
        'class' => 'form-control',
        'id' => 'namasatuan',
        'autofocus' => true,
        'placeholder' => 'isikan nama Satuan'
    ]) ?>

    <?= session()->getFlashdata('errorNamaSatuan');?>
</div>

<div class="form-group">
    <?= form_submit('', 'Simpan Satuan', [
    'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>