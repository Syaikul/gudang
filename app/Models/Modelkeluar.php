<?php

namespace App\Models;

use CodeIgniter\Model;

class Modelkeluar extends Model
{
    protected $table            = 'keluar';
    protected $primaryKey       = 'klrkode';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['klrbrgkode', 'klrtanggal', 'klrjumlah', 'clientid', 'klrketerangan'];

    /**
     * Menghitung Weighted Moving Average (WMA) berdasarkan data keluar per bulan.
     *
     * @param string $brgkode Kode barang
     * @param int $bulanCount Jumlah bulan periode (default 3 bulan)
     * @return int Perkiraan kebutuhan bulan depan berdasarkan WMA
     */

    public function getWMAByBarang(string $brgkode, int $bulanCount = 3): int
    {
        $builder = $this->db->table($this->table);
        $builder->select("MONTH(klrtanggal) as bulan, YEAR(klrtanggal) as tahun, SUM(klrjumlah) as total");
        $builder->where('klrbrgkode', $brgkode);
        // Ambil data  bulan terakhir sesuai $bulanCount (terhitung dari bulan sekarang)
        $builder->where('klrtanggal >=', date('Y-m-01', strtotime("-" . ($bulanCount - 1) . " months")));
        $builder->groupBy(['tahun', 'bulan']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');
        $query = $builder->get()->getResultArray();

        // Bobot WMA (bulan terbaru paling besar)
        $bobot = array_slice(range($bulanCount, 1), 0, count($query)); // misal 3,2,1
        $totalBobot = array_sum($bobot);

        $totalNilai = 0;
        foreach ($query as $i => $row) {
            $totalNilai += $row['total'] * $bobot[$i];
        }

        return ($totalBobot > 0) ? (int) ceil($totalNilai / $totalBobot) : 0;
    }
}
