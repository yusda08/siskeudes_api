<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model_Auth
 *
 * @author Yusda Helmani
 */

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;
use CodeIgniter\Validation\ValidationInterface;

class M_Cek extends Model
{
    //put your code here
    private \CodeIgniter\Database\BaseConnection $dbSiskeudes;

    public function __construct(ConnectionInterface &$db = null, ValidationInterface $validation = null)
    {
        parent::__construct($db, $validation);
        $this->dbSiskeudes = \Config\Database::connect('dbSiskeudes');
    }

    public final function getCek(): \CodeIgniter\Database\Query|bool|\CodeIgniter\Database\BaseResult
    {
        return $this->dbSiskeudes->query('select * from Ref_Rek1');
    }


}
