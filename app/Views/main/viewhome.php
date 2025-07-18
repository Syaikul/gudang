<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
<h3>Halo <?= user()->username; ?> 👋</h3>

<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
<h2 class="text-center">Tabel dan Grafik Barang Masuk / Keluar Tahun <?= date('Y'); ?></h2>
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<section class="content">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered table-striped" id="normal">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($dataGabungan)) : ?>
                        <?php $no = 1;
                        foreach ($dataGabungan as $row) : ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= esc($row['brgnama']); ?></td>
                                <td>
                                    <?php if ($row['status'] == 'Masuk') : ?>
                                        <span class="badge badge-success">Masuk</span>
                                    <?php else : ?>
                                        <span class="badge badge-danger">Keluar</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= esc($row['jumlah']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data barang masuk/keluar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <canvas id="chartjs-line" style="width: 100%; height: 400px;"></canvas>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("chartjs-line").getContext("2d");

        const barangMasuk = <?= json_encode($grafikMasuk); ?>;
        const barangKeluar = <?= json_encode($grafikKeluar); ?>;

        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: "Barang Masuk",
                        fill: false,
                        borderColor: "#075B5E",
                        backgroundColor: "#075B5E",
                        tension: 0.3,
                        data: barangMasuk
                    },
                    {
                        label: "Barang Keluar",
                        fill: false,
                        borderColor: "#FF3F33",
                        backgroundColor: "#FF3F33",
                        borderDash: [5, 5],
                        tension: 0.3,
                        data: barangKeluar
                    }
                ]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "top"
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    });
</script>

<?= $this->endSection() ?>