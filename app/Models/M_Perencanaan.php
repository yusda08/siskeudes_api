<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class M_Perencanaan extends Model
{
    //put your code here
    private \CodeIgniter\Database\BaseConnection $dbSiskeudes;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbSiskeudes = \Config\Database::connect('dbSiskeudes');
    }

    public final function getTaBidang($tahun, string $kd_kec = null): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_Bidang WHERE Tahun={$tahun} {$where}");
    }

    public final function getTaSubBidang($tahun, string $kd_kec = null): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_SubBidang WHERE Tahun={$tahun} {$where}");
    }

    public final function getTaKegiatan($tahun, string $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_Kegiatan WHERE Tahun={$tahun} {$where}");
    }

    public final function getTaRab($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT a.*, b.Nama_Obyek FROM Ta_Rab a JOIN Ref_Rek4 b ON a.Kd_Rincian=b.Obyek WHERE Tahun=$tahun and SUBSTRING(a.Kd_Rincian,1,1)='5' {$where}");
    }

    public final function getTaRabRinci($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_RABRinci WHERE Tahun=$tahun {$where}");
    }

}
