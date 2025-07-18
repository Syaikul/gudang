<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Form Tambah Level
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-backward"></i> Kembali', [
    'class' => 'btn btn-warning',
    'onclick' => "location.href=('" . site_url('level/index') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= form_open('level/simpanlevel') ?>
<div class="form-group">
    <label for="namalevel">Nama Level</label>
    <?= form_input('namalevel', '', [
        'class' => 'form-control',
        'id' => 'namalevel',
        'autofocus' => true,
        'placeholder' => 'Contoh: LOW, MEDIUM, HIGH'
    ]) ?>
    <?= session()->getFlashdata('errorNamaLevel'); ?>
</div>

<div class="form-group">
    <label for="angka">Angka Level</label>
    <?= form_input('angka', '', [
        'class' => 'form-control',
        'id' => 'angka',
        'placeholder' => 'Contoh: 100, 200, 300'
    ]) ?>
    <?= session()->getFlashdata('errorAngkaLevel'); ?>
</div>

<div class="form-group">
    <?= form_submit('', 'Simpan Level', [
        'class' => 'btn btn-success'
    ]) ?>
</div>
<?= form_close(); ?>
<?= $this->endSection() ?>