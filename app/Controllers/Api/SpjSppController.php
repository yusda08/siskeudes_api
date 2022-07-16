<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\M_Spj;
use App\Models\M_Spp;
use CodeIgniter\API\ResponseTrait;

class SpjSppController extends BaseController
{
    use ResponseTrait;

    private M_Spp $M_Spp;
    private M_Spj $M_Spj;

    public function __construct()
    {
        $this->M_Spp = new M_Spp();
        $this->M_Spj = new M_Spj();
    }

    public final function spj(): \CodeIgniter\HTTP\Response
    {
        try {
            $getData = $this->_spj();
            $array = parent::setResponse('Success', 200, $getData);
        } catch (\Throwable $th) {
            $array = parent::setResponse($th->getMessage(), 400);
        }
        return $this->respond($array, $array['status']);
    }

    public final function spp(): \CodeIgniter\HTTP\Response
    {
        try {
            $getData = $this->_spp();
            $array = parent::setResponse('Success', 200, $getData);
        } catch (\Throwable $th) {
            $array = parent::setResponse($th->getMessage(), 400);
        }
        return $this->respond($array, $array['status']);
    }


    private function _spj(): array
    {
        $kecamatan = $this->request->getGet('kecamatan');
        $tahun = $this->request->getGet('tahun');
        $getDataRab = $this->M_Spj->getTaSpj($tahun, $kecamatan)->getResultArray();
        $getDataRincian = $this->M_Spj->getTaSpjBukti($tahun, $kecamatan)->getResultArray();
        foreach ($getDataRab as $i => $item) {
            $dataRinc = [];
            foreach ($getDataRincian as $rinc) {
                if ($item['No_SPJ'] == $rinc['No_SPJ']) {
                    $dataRinc[] = $rinc;
                }
            }
            $getDataRab[$i]['bukti'] = $dataRinc;
        }
        return $getDataRab;
    }

    private function _spp(): array
    {
        $kecamatan = $this->request->getGet('kecamatan');
        $tahun = $this->request->getGet('tahun');
        $getDataSpp = $this->M_Spp->getTaSpp($tahun, $kecamatan)->getResultArray();
        $getDataSppBukti = $this->M_Spp->getTaSppBukti($tahun, $kecamatan)->getResultArray();
        foreach ($getDataSpp as $i => $spp) {
            $dataBukti = [];
            foreach ($getDataSppBukti as $sppBukti) {
                if ($spp['No_SPP'] == $sppBukti['No_SPP']) {
                    $dataBukti[] = $sppBukti;
                }
            }
            $getDataSpp[$i]['bukti'] = $dataBukti;
        }
        return $getDataSpp;
    }

}
