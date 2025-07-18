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

    public function getWMAByBarang(string $brgkode, array $customWeights = [0.1, 0.2, 0.3, 0.4, 0.5]): int
    {
        // jumlah bulan dari panjang array bobot
        $bulanCount = count($customWeights);

        // tanggal mulai berdasarkan jumlah bulan
        $startDate = date('Y-m-01', strtotime("-" . ($bulanCount - 1) . " months"));

        $builder = $this->db->table($this->table);
        $builder->select("MONTH(klrtanggal) as bulan, YEAR(klrtanggal) as tahun, SUM(klrjumlah) as total");
        $builder->where('klrbrgkode', $brgkode);
        $builder->where('klrtanggal >=', $startDate);
        $builder->groupBy(['tahun', 'bulan']);
        $builder->orderBy('tahun', 'DESC');
        $builder->orderBy('bulan', 'DESC');

        $query = $builder->get()->getResultArray();

        if (empty($query)) {
            return 0;
        }


        $availableWeights = array_slice(array_reverse($customWeights), 0, count($query));


        $totalNilai = 0;
        $totalBobot = array_sum($availableWeights);

        foreach ($query as $i => $row) {
            $totalNilai += $row['total'] * $availableWeights[$i];
        }

        return ($totalBobot > 0) ? (int) ceil($totalNilai / $totalBobot) : 0;
    }
}
