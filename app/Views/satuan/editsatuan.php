<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Satuan
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href='" . site_url('satuan/index') . "'"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('satuan/updatesatuan') ?>
<?= form_hidden('idsatuan', $id) ?>

<div class="form-group">
    <label for="namasatuan">Nama Satuan</label>
    <?= form_input('namasatuan', $nama, [
        'class' => 'form-control',
        'id' => 'namasatuan',
        'autofocus' => true
    ]) ?>
    <?= session()->getFlashdata('errorNamaSatuan'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Update Satuan', [
        'class' => 'btn btn-success'
    ]) ?>
</div>

<?= form_close(); ?>
<?= $this->endSection() ?>