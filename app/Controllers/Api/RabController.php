<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\M_Rab;
use CodeIgniter\API\ResponseTrait;

class RabController extends BaseController
{
    use ResponseTrait;

    private M_Rab $M_Rab;

    public function __construct()
    {
        $this->M_Rab = new M_Rab();
    }

    public final function rab(): \CodeIgniter\HTTP\Response
    {
        try {
            $getData = $this->_rab();
            $array = parent::setResponse('Success', 200, $getData);
        } catch (\Throwable $th) {
            $array = parent::setResponse($th->getMessage(), 400);
        }
        return $this->respond($array, $array['status']);
    }


    private function _rab(): array
    {
        $kecamatan = $this->request->getGet('kecamatan');
        $tahun = $this->request->getGet('tahun');
        $getDataRab = $this->M_Rab->getTaRab($tahun, $kecamatan)->getResultArray();
        $getDataRincian = $this->M_Rab->getTaRabRinci($tahun, $kecamatan)->getResultArray();
        foreach ($getDataRab as $i => $item) {
            $dataRinc = [];
            foreach ($getDataRincian as $rinc) {
                if ($item['Kd_Desa'] == $rinc['Kd_Desa']
                    and $item['Kd_Keg'] == $rinc['Kd_Keg']
                    and $item['Kd_Rincian'] == $rinc['Kd_Rincian']
                    and $item['Kd_SubRinci'] == $rinc['Kd_SubRinci']
                ) {
                    $dataRinc[] = $rinc;
                }
            }
            $getDataRab[$i]['rincian'] = $dataRinc;
        }
        return $getDataRab;
    }

}
