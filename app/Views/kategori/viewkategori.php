<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
Manajemen data kategori
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<?= form_button('', '<i class="fa fa-plus-circle"></i> Tambah Data', [
    'class' => 'btn btn-primary',
    'onclick' => "location.href=('" . site_url('kategori/tambahkategori') . "')"
]) ?>



<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<?= session()->getFlashdata('sukses'); ?>
<table class="table table-striped table-bordered" style="width:100%;" id='tabel'>
    <thead>
        <tr>
            <th style="width: 5%;">No</th>
            <th>Nama Kategori</th>
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
                <td><?= $row['katnama']; ?></td>
                <td>
                    <button type="button" class="btn btn-info" title="Edit Kategori" onclick="edit('<?= $row['katid'] ?>')">
                        <i class="fa fa-edit"></i>
                    </button>
                    <button type="button" class="btn btn-danger" title="Hapus Kategori" onclick="hapus ('<?= $row['katid'] ?>')">
                        <i class="fa fa-trash-alt"></i>
                    </button>
                </td>

            </tr>
        <?php endforeach ?>

        <?php
        $nomor = 1;
        $max_rows = 20; // batas maksimal baris
        $count = 0;

        foreach ($tampildata as $row):
            if (isset($row['show']) && $row['show'] == 1): // pengecekan show == 1
                if ($count >= $max_rows) break;
        ?>
                <tr>
                    <td><?= $nomor++; ?></td>
                    <td><?= $row['katnama']; ?></td>
                    <td>
                        <a href="<?= base_url('kategori/hapus/' . $row['katid']) ?>" class="btn btn-danger hapus">Hapus</a>
                        <button class="btn btn-warning edit" data-id="<?= $row['katid'] ?>">Edit</button>
                    </td>
                </tr>
        <?php
                $count++;
            endif;
        endforeach;
        ?>

    </body>
</table>
<script>
    function edit(id) {
        window.location = "<?= site_url('kategori/editkategori') ?>/" + id;
    }

    function hapus(id) {
        pesan = confirm('Apakah anda yakin ingin menghapus kategori ini ?');

        if (pesan) {
            window.location = "<?= site_url('kategori/hapuskategori') ?>/" + id;

        } else {
            return false;
        }
    }
</script>



<?= $this->endSection() ?>