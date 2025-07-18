<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Client
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('client/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('client/updateclient', '', [
    'idclient' => $id
]) ?>
<div class="form-group">
    <label for="namaclient">Nama Client</label>
    <?= form_input('namaclient', $nama, [
        'class' => 'form-control',
        'id' => 'namaclient',
        'autofocus' => true,
    ]) ?>
    <?= session()->getFlashdata('errorNamaClient'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Update Client', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>