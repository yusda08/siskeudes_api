<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\M_Cek;
use App\Models\M_Perencanaan;
use App\Models\M_Referensi;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class PerencanaanController extends BaseController
{
    use ResponseTrait;

    private M_Perencanaan $M_Perencanaan;

    public function __construct()
    {
        $this->M_Perencanaan = new M_Perencanaan();
    }

    public final function bidang(): \CodeIgniter\HTTP\Response
    {
        try {
            $data = $this->_bidang();
            $response = parent::setResponse(response: ResponseInterface::HTTP_OK, data: $data);
        } catch (\Exception $exception) {
            $response = parent::setResponse(msg: $exception->getMessage());
        }
        return $this->respond($response, $response['status']);
    }

    private function _bidang(): array
    {
        $kecamatan = $this->request->getGet('kecamatan');
        $tahun = $this->request->getGet('tahun');
        $getData = $this->M_Perencanaan->getTaBidang($tahun, $kecamatan)->getResultArray();
        $dataSubBidang = $this->M_Perencanaan->getTaSubBidang($tahun, $kecamatan)->getResultArray();
        $dataKegiatan = $this->M_Perencanaan->getTaKegiatan($tahun, $kecamatan)->getResultArray();
        foreach ($getData as $i => $bid) {
            $arrSubBid = [];
            foreach ($dataSubBidang as $subbid) {
                if ($bid['Kd_Bid'] == $subbid['Kd_Bid']) {
                    $arrKeg = [];
                    foreach ($dataKegiatan as $keg) {
                        if ($subbid['Kd_Sub'] == $keg['Kd_Sub']) {
                            $arr3['Kd_Keg'] = $keg['Kd_Keg'];
                            $arr3['ID_Keg'] = $keg['ID_Keg'];
                            $arr3['Nama_Kegiatan'] = $keg['Nama_Kegiatan'];
                            $arr3['Pagu'] = (float)$keg['Pagu'];
                            $arr3['Pagu_PAK'] = (float)$keg['Pagu_PAK'];
                            $arr3['Nm_PPTKD'] = $keg['Nm_PPTKD'];
                            $arr3['NIP_PPTKD'] = $keg['NIP_PPTKD'];
                            $arr3['Jbt_PPTKD'] = $keg['Jbt_PPTKD'];
                            $arr3['Lokasi'] = $keg['Lokasi'];
                            $arr3['Waktu'] = $keg['Waktu'];
                            $arr3['Keluaran'] = $keg['Keluaran'];
                            $arr3['Sumberdana'] = $keg['Sumberdana'];
                            $arr3['Nilai'] = (float)$keg['Nilai'];
                            $arr3['NilaiPAK'] = (float)$keg['NilaiPAK'];
                            $arr3['Satuan'] = $keg['Satuan'];
                            $arrKeg[] = $arr3;
                        }
                    }
                    $arr2['Kd_Sub'] = $subbid['Kd_Sub'];
                    $arr2['Nama_SubBidang'] = $subbid['Nama_SubBidang'];
                    $arr2['kegiatan'] = $arrKeg;
                    $arrSubBid[] = $arr2;
                }
            }
            $getData[$i]['sub_bidang'] = $arrSubBid;
        }
        return $getData;
    }

}
