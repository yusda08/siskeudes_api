<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class M_Spp extends Model
{
    //put your code here
    private \CodeIgniter\Database\BaseConnection $dbSiskeudes;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbSiskeudes = \Config\Database::connect('dbSiskeudes');
    }

    function getTaSpp($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_SPP WHERE Tahun=$tahun {$where}");
    }

    function getTaSppBukti($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_SPPBukti WHERE Tahun=$tahun {$where}");
    }

}
