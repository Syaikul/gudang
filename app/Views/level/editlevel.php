<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Edit Level
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('level/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('level/updatelevel') ?>
<?= form_hidden('idlevel', $id) ?>

<div class="form-group">
    <label for="namalevel">Nama Level</label>
    <?= form_input('namalevel', $nama, [
        'class' => 'form-control',
        'id' => 'namalevel',
        'autofocus' => true,
        'placeholder' => 'isikan nama level'
    ]) ?>
    <?= session()->getFlashdata('errorNamaLevel'); ?>
</div>

<div class="form-group">
    <label for="angka">Angka Level</label>
    <?= form_input('angka', $angka, [
        'class' => 'form-control',
        'id' => 'angka',
        'placeholder' => 'contoh: 100'
    ]) ?>
    <?= session()->getFlashdata('errorAngkaLevel'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Update Level', [
        'class' => 'btn btn-success'
    ]) ?>
</div>

<?= form_close(); ?>
<?= $this->endSection() ?>