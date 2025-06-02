<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen Data Client
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('client/tambahclient') . "')"
]) ?>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('sukses'); ?>
<table class="table table-striped table-bordered" style="width:100%;" id='tabel'>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Client</th>
            <th style="width: 15%;">Aksi</th>
        </tr>
    </thead>

    <body>
        <?php
        $nomor = 1;
        foreach ($tampildata as $row):
        ?>
            <tr>
                <td><?= $nomor++; ?></td>
                <td><?= $row['clientnama']; ?></td>
                <td>
                    <button type="button" class="btn btn-info" title="Edit Client" onclick="edit('<?= $row['clientid'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" title="Hapus Client" onclick="hapus ('<?= $row['clientid'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>
            </tr>
        <?php endforeach ?>
    </body>
</table>

<script>
    function edit(id) {
        window.location = "<?= site_url('client/editclient') ?>/" + id;
    }

    function hapus(id) {
        pesan = confirm('Apakah anda yakin ingin menghapus client ini ?');

        if (pesan) {
            window.location = "<?= site_url('client/hapusclient') ?>/" + id;

        } else {
            return false;
        }
    }
</script>

<?= $this->endSection() ?>