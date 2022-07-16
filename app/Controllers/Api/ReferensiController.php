<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\M_Cek;
use App\Models\M_Referensi;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class ReferensiController extends BaseController
{
    use ResponseTrait;


    private M_Referensi $M_Ref;

    public function __construct()
    {
        $this->M_Ref = new M_Referensi();
    }

    public final function lokasi(): \CodeIgniter\HTTP\Response
    {
        try {
            $data = $this->_refLokasi();
            $response = parent::setResponse(response: ResponseInterface::HTTP_OK, data: $data);
        } catch (\Exception $exception) {
            $response = parent::setResponse(msg: $exception->getMessage());
        }
        return $this->respond($response, $response['status']);
    }

    public final function rekening(): \CodeIgniter\HTTP\Response
    {
        try {
            $data = $this->_refRekening();
            $response = parent::setResponse(response: ResponseInterface::HTTP_OK, data: $data);
        } catch (\Exception $exception) {
            $response = parent::setResponse(msg: $exception->getMessage());
        }
        return $this->respond($response, $response['status']);
    }

    private function _refRekening(): array
    {
        $getsRek1 = $this->M_Ref->getRefRek1Belanja()->getResultArray();
        $getsRek2 = $this->M_Ref->getRefRek2Belanja()->getResultArray();
        $getsRek3 = $this->M_Ref->getRefRek3Belanja()->getResultArray();
        $getsRek4 = $this->M_Ref->getRefRek4Belanja()->getResultArray();
        foreach ($getsRek1 as $i => $rek1) {
            foreach ($getsRek2 as $i2 => $rek2) {
                if ($rek2['Akun'] == $rek1['Akun']) {
                    $arrayRek3 = [];
                    foreach ($getsRek3 as $rek3) {
                        if ($rek2['Kelompok'] == $rek3['Kelompok']) {
                            $arrayRek4 = [];
                            foreach ($getsRek4 as $rek4) {
                                if ($rek4['Jenis'] == $rek3['Jenis']) {
                                    $arr4['Jenis'] = $rek4['Jenis'];
                                    $arr4['Obyek'] = $rek4['Obyek'];
                                    $arr4['Nama_Obyek'] = $rek4['Nama_Obyek'];
                                    $arr4['Peraturan'] = $rek4['Peraturan'];
                                    $arrayRek4[] = $arr4;
                                }
                            }
                            $arr3['Kelompok'] = $rek3['Kelompok'];
                            $arr3['Jenis'] = $rek3['Jenis'];
                            $arr3['Nama_Jenis'] = $rek3['Nama_Jenis'];
                            $arr3['Formula'] = $rek3['Formula'];
                            $arr3['rek_4'] = $arrayRek4;
                            $arrayRek3[] = $arr3;
                        }
                    }
                    $getsRek2[$i2]['rek_3'] = $arrayRek3;
                }
            }
            $getsRek1[$i]['rek_2'] = $getsRek2;
        }
        return $getsRek1;
    }

    private function _refLokasi(): array
    {
        $getsRekKec = $this->M_Ref->getRefKecamatan()->getResultArray();
        $getsRekDesa = $this->M_Ref->getRefDesa()->getResultArray();
        foreach ($getsRekKec as $i => $kec) {
            $getsDesa = [];
            foreach ($getsRekDesa as $i2 => $desa) {
                if ($desa['Kd_Kec'] == $kec['Kd_Kec']) {
                    $getsDesa[] = $desa;
                }
            }
            $getsRekKec[$i]['desa'] = $getsDesa;
        }
        return $getsRekKec;
    }

}
