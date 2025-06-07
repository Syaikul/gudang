<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Laporan Biaya pengeluaran
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
Form Rekap
<?= $this->endSection() ?>

<?= $this->section('isi') ?>

<form action="<?= site_url('biaya/cetak') ?>" method="post">
    <?= csrf_field() ?>

    <div class="form-group">
        <label for="clientid">Client</label>
        <select name="clientid" id="clientid" class="form-control">
            <option value="">-- Semua Client --</option>
            <?php foreach ($client as $c) : ?>
                <option value="<?= esc($c['clientid']) ?>"><?= esc($c['clientnama']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <label for="dari_bulan">Dari Bulan</label>
        <input type="month" name="dari_bulan" id="dari_bulan" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="sampai_bulan">Sampai Bulan</label>
        <input type="month" name="sampai_bulan" id="sampai_bulan" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Cetak</button>
</form>

<?= $this->endSection() ?>