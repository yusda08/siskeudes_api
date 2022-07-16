<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\M_Cek;
use CodeIgniter\API\ResponseTrait;

class Cek extends BaseController
{
    use ResponseTrait;

    private M_Cek $M_Cek;

    public function __construct()
    {
        $this->M_Cek = new M_Cek();
    }

    public final function index(): \CodeIgniter\HTTP\Response
    {
        try {
            $getData = $this->M_Cek->getCek()->getResultArray();
            $array = parent::setResponse('Success', 200, $getData);
        } catch (\Throwable $th) {
            $array = parent::setResponse($th->getMessage(), 400);
        }
        return $this->respond($array, $array['status']);
    }

}
