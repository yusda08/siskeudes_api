<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class M_Spj extends Model
{
    //put your code here
    private \CodeIgniter\Database\BaseConnection $dbSiskeudes;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbSiskeudes = \Config\Database::connect('dbSiskeudes');
    }

    function getTaSpj($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_SPJ WHERE Tahun=$tahun {$where}");
    }

    function getTaSpjBukti($tahun, $kd_kec = null)
    {
        $where = $kd_kec ? "and SUBSTRING(Kd_Desa,1,2)='{$kd_kec}'" : '';
        return $this->dbSiskeudes->query("SELECT * FROM Ta_SPJBukti WHERE Tahun=$tahun {$where}");
    }

}
