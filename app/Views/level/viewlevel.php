<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Level
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('level/tambahlevel') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('sukses'); ?>

<table class="table table-striped table-bordered" style="width:100%;" id='tabel'>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Level</th>
            <th>Level</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>

    <tbody>
        <?php
        $nomor = 1;
        foreach ($tampildata as $row):
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['levelnama']; ?></td>
                <td><?= $row['level']; ?></td>
                <td>
                    <button type="button" class="btn btn-info" title="Edit Level" onclick="edit('<?= $row['idlevel'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" title="Hapus Level" onclick="hapus('<?= $row['idlevel'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>

<script>
    function edit(id) {
        window.location = "<?= site_url('level/editlevel') ?>/" + id;
    }

    function hapus(id) {
        pesan = confirm('Apakah anda yakin ingin menghapus level ini?');
        if (pesan) {
            window.location = "<?= site_url('level/hapuslevel') ?>/" + id;
        } else {
            return false;
        }
    }
</script>

<?= $this->endSection() ?>