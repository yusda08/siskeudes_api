<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class M_Referensi extends Model
{
    //put your code here
    private \CodeIgniter\Database\BaseConnection $dbSiskeudes;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbSiskeudes = \Config\Database::connect('dbSiskeudes');
    }

    public final function getRefRek1Belanja(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Rek1 a WHERE SUBSTRING(a.Akun,1,1)='5';");
    }

    public final function getRefRek2Belanja(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Rek2 a WHERE SUBSTRING(a.Kelompok,1,1)='5';");
    }

    public final function getRefRek3Belanja(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Rek3 a WHERE SUBSTRING(a.Jenis,1,1)='5';");
    }

    public final function getRefRek4Belanja(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Rek4 a WHERE SUBSTRING(a.Obyek,1,1)='5';");
    }


    public final function getRefKecamatan(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Kecamatan");
    }

    public final function getRefDesa(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query("SELECT * FROM Ref_Desa");
    }


}
