<?= $this->extend('main/layout') ?>

<?= $this->section('judul') ?>
<h3>Halo <?= user()->username; ?> 👋</h3>
<?= $this->endSection() ?>

<?= $this->section('subjudul') ?>
Home
<?= $this->endSection() ?>

<?= $this->section('isi') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<section class="content">
    <div class="row">
        <div class="col-md-6">
            <table class="table table-striped table-bordered" style="width:100%;">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Nama Barang</th>
                        <th>Status</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($aktivitas)): ?>
                        <?php $nomor = 1; ?>
                        <?php foreach ($aktivitas as $row): ?>
                            <tr>
                                <td><?= $nomor++; ?></td>
                                <td><?= esc($row['nama']); ?></td>
                                <td><?= esc($row['status']); ?></td>
                                <td><?= esc($row['jumlah']); ?></td>
                                <td><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data aktivitas</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <canvas id="chartjs-line" width="400" height="300"></canvas>
        </div>
    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const ctx = document.getElementById("chartjs-line").getContext("2d");

        const barangMasuk = <?= isset($grafikMasuk) ? json_encode(array_values($grafikMasuk)) : '[]'; ?>;
        const barangKeluar = <?= isset($grafikKeluar) ? json_encode(array_values($grafikKeluar)) : '[]'; ?>;

        new Chart(ctx, {
            type: "line",
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                        label: "Barang Masuk",
                        fill: true,
                        backgroundColor: "transparent",
                        borderColor: "#007bff",
                        data: barangMasuk
                    },
                    {
                        label: "Barang Keluar",
                        fill: true,
                        backgroundColor: "transparent",
                        borderColor: "#adb5bd",
                        borderDash: [4, 4],
                        data: barangKeluar
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        grid: {
                            color: "rgba(0,0,0,0.05)"
                        }
                    },
                    y: {
                        grid: {
                            color: "rgba(0,0,0,0)",
                            borderDash: [5, 5]
                        }
                    }
                }
            }
        });
    });
</script>


<?= $this->endSection() ?>