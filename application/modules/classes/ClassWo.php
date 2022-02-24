<?php

namespace app\modules\classes;

use Exception;
use app\modules\elo_models\honda_sp\mItem;
use app\modules\elo_models\honda\mBukuBesar;
use app\modules\elo_models\honda\mNomorEFaktur;
use app\modules\elo_models\honda_as\mWorkOrder;
use app\modules\elo_models\honda_as\mWoDetailJasa;
use app\modules\elo_models\honda_as\mWoDetailLain;
use app\modules\elo_models\honda_as\mWoDetailPart;
use app\modules\elo_models\honda\mPenerimaanBengkel;
use app\modules\elo_models\honda\mPenerimaanBengkelAlokasi;
use app\modules\elo_models\honda_as\mInvoiceAfterSales;

if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * ClassWo | Kelas induk dari semua transaki service wo
 * Cara penggunaan.
 * 1. Init Class
 * 2. Panggil method setNoWo($noWo) atau setNoInvoice($noInvoice)
 * @author  Andi Chaerul <chairul.kumalamotor@gmail.com>
 */
class ClassWo extends \MX_Controller
{
    public $noWo;
    public $noInvoice;
    public $tglInvoice;
    public $jenisInvoice;
    public $noEFaktur;
    public $dataWo;
    public $jasaWoAll;
    public $jasa;
    public $partWoAll;
    public $part;
    public $oplWoAll;
    public $opl;
    public $biayaWo;
    public $penerimaan;
    public $ambilSemuaDataOtomatis = true;
    public $sisaArByKasir;


    /**
     * setNoWo
     *
     * @param  mixed $noWo no wo yg datanya ingin di tarik
     * @return void
     */
    public function setNoWo($noWo)
    {
        $this->noWo = $noWo;
    }

    /**
     * setNoInvoice
     *
     * @param  mixed $noInvoice
     * @return void
     */
    public function setNoInvoice($noInvoice)
    {
        $this->noInvoice = $noInvoice;

        if ($this->ambilSemuaDataOtomatis) {
            $this->getNoWoByNoInvoice();
            $this->setJenisInvoice();
            $this->ifNoInvoiceWO();

            /* panggil semua method get*/
            $this->getDataWo();
            $this->getJasaWo();
            $this->getPartWo();
            $this->getOplWo();
            $this->getNoEFaktur();
            $this->getPenerimaan();
            $this->getBiayaWo();
        }
        return $this;
    }

    /**
     * getNoWoByNoInvoice | Get no Wo by no invoice
     *
     * @return void
     */
    public function getNoWoByNoInvoice()
    {
        $data = mInvoiceAfterSales::whereNoInvoice($this->noInvoice);
        /* set no wo jika no ref ada pada invoice after sales */
        if ($data->count() > 0) {
            $this->noWo = $data->first()->no_ref;
        } else {
            /* Jika no invoice mengadung WO.REG1 berarti ini adalah invoice masih menggunakan no wo,  */
            if (strpos($this->noInvoice, 'WO.REG1-') !== false) {
                /* Lakukan set wo */
                $this->noWo = $this->noInvoice;
            }
        }
    }


    /**
     * getNoFaktur Get no Efaktur
     *
     * @return void
     */
    private function getNoEFaktur()
    {
        $noEfaktur = mNomorEFaktur::whereNoTransaksi($this->noInvoice);
        $this->noEFaktur = $noEfaktur->first()->no_e_faktur ?? '';
    }


    /**
     * setJenisInvoice set Jenis Invoice
     *
     * @return void
     */
    private function setJenisInvoice()
    {
        /* Jika no invoice mengandung INV-WO berarti set jenis inv menjadi customer */
        if (strpos($this->noInvoice, 'INV-WO.') !== false) {
            $this->jenisInvoice = "customer";
            /* Jika no invoice mengandung INV-WO-CLM. set jenis inv menjadi claim */
        } else if (strpos($this->noInvoice, 'INV-WO-CLM.') !== false) {
            $this->jenisInvoice = "claim";
        } else {
            $this->jenisInvoice = null;
        }
    }

    /**
     * getDataWo mengambil data profil work order
     *
     * @return void
     */
    public function getDataWo()
    {
        $dataWo = mWorkOrder::whereNoWo($this->noWo)
            ->with('toCustomer', 'toDetailUnitCustomer', 'toEstimasi')
            ->get();
        $dataWo = $dataWo->map(function ($row) {
            /* Jika customer ada */
            if (!empty($row->toCustomer->nama)) {
                /* Jika jenis invoice adalah claim maka update customer ke HPM */
                if ($this->jenisInvoice == "claim") {
                    $row->toCustomer->nama = "HONDA PROSPECT MOTOR";
                    $row->toCustomer->telepon = "0216510403";
                    $row->toCustomer->alamat = "Jl. Gaya Motor I Sunter II, Jakarta 14330";
                    $row->toCustomer->npwp = "010002400092000";
                }
            }
            return $row;
        });
        $this->dataWo = $dataWo->toArray();
    }


    /**
     * getJasaWo Get detail jasa wo
     *
     * @return void 
     */
    public function getJasaWo()
    {
        switch ($this->jenisInvoice) {
            case 'claim':
                $this->jasa = $this->queryJasa("claim")->toArray();
                break;
            case 'customer':
                $this->jasa = $this->queryJasa("customer")->toArray();
                break;
            default:
                $this->jasa = $this->queryJasa()->toArray();
                break;
        }
    }

    /**
     * getPartWo Get detail Part wo
     *
     * @return void 
     */
    public function getPartWo()
    {
        switch ($this->jenisInvoice) {
            case 'claim':
                $this->part = $this->queryPart("claim")->toArray();
                break;
            case 'customer':
                $this->part = $this->queryPart("customer")->toArray();
                break;
            default:
                $this->part = $this->queryPart()->toArray();
                break;
        }
    }

    /**
     * getOplWo ambil data opl
     *
     * @return void
     */
    public function getOplWo()
    {
        switch ($this->jenisInvoice) {
            case 'claim':
                $this->opl = $this->queryOpl("claim")->toArray();
                break;
            case 'customer':
                $this->opl = $this->queryOpl("customer")->toArray();
                break;
            default:
                $this->opl = $this->queryOpl()->toArray();
                break;
        }
    }

    /**
     * queryJasa query penarikan data woDetailjasa
     *
     * @param  mixed $claimOrNo
     * @return object
     */
    private function queryJasa($claimOrNo = null)
    {
        $data = mWoDetailJasa::whereNoWo($this->noWo);
        switch ($claimOrNo) {
            case 'claim':
                $data = $data->whereClaim("y");
                break;
            case 'customer':
                $data = $data->whereClaim("n");
                break;
        }
        $data = $data->whereDel("0")
            ->with('toJasa', 'toJasa.toPNamaJasa');
        $data = $data->get();
        $data = $data->map(function ($row) {
            $row->totalSebelumDiskon = $row->harga_jual * $row->qty;
            $row->totalSetelahDiskon = $totalSetelahDiskon = ($row->harga_jual * $row->qty) - $row->diskon_rp;
            $row->ppnJasa = round((10 / 100) * $totalSetelahDiskon);
            /* Jika claim n lakukan validasi, dan y tidak perlu lakukan validasi, karena semua datanya sdh penarikan by rumus class ini */
            if ($row->claim == "n") {
                $this->makeSureData($row->totalSetelahDiskon, $row->total, "{$this->noWo} Total jasa salah");
                $diskonPersenByRms = $this->getDiskonPersen($row->totalSebelumDiskon, $row->totalSetelahDiskon);
                //$this->makeSureData($diskonPersenByRms, $row->diskon, "Diskon persen jasa salah"); disable diskon persen jasa
            }
            return $row;
        });
        // dd($data->toArray());
        return $data;
    }

    /**
     * queryPart query penarikan data woDetailpart
     *
     * @param  mixed $claimOrNo
     * @return object
     */
    private function queryPart($claimOrNo = null)
    {
        $data = mWoDetailPart::whereNoWo($this->noWo);
        switch ($claimOrNo) {
            case 'claim':
                $data = $data->whereClaim("y");
                break;
            case 'customer':
                $data = $data->whereClaim("n");
                break;
        }
        $data = $data->whereDel("0")
            ->whereSRequest("2")
            ->with([
                'toItem',
                'toItem.toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian(2);
                },
            ])
            ->get();
        $data = $data->map(function ($row) {
            $diskonPersen = $this->getHppPart($row->kode_item);
            $diskonRp = round(($diskonPersen / 100) * $row->harga_jual);
            $row->totalSebelumDiskon = $row->harga_jual * $row->qty;
            $row->totalSetelahDiskon = $totalSetelahDiskon = ($row->harga_jual * $row->qty) - $row->diskon_rp;
            $row->ppnPart = round((10 / 100) * $totalSetelahDiskon);
            $row->hppSatuan = $row->harga_jual - $diskonRp;
            $row->hppTotal = $row->hppSatuan * $row->qty;
            /* Cari Nilai Oli */
            $namaOpl = $row->toItem->nama_item ?? "";
            if (strpos($namaOpl, 'OIL') !== false && $row->toItem->jenis_item != "part") { /* Jikan nama item mengadung oli atau jenis item adalah part */
                $row->biayaOliSetelahDiskon = $totalSetelahDiskon;
            } else {
                $row->biayaOliSetelahDiskon = 0;
            }
            /* Jika claim n lakukan validasi, dan y tidak perlu lakukan validasi, karena semua datanya sdh penarikan by rumus class ini */
            if ($row->claim == "n") {
                $this->makeSureData($row->totalSetelahDiskon, $row->total, "Total part salah");
                $diskonPersenByRms = $this->getDiskonPersen($row->totalSebelumDiskon, $row->totalSetelahDiskon, $row->qty);
                // if ($row->qty > 0) {
                //     $this->makeSureData($diskonPersenByRms, $row->diskon, "{$this->noWo} Diskon persen part salah"); disable diskon persen part
                // }
            }
            return $row;
        });
        return $data;
    }

    /**
     * queryOpl query penarikan woDetailOpl
     *
     * @param  mixed $claimOrNo
     * @return object
     */
    private function queryOpl($claimOrNo = null)
    {
        $data = mWoDetailLain::whereNoWo($this->noWo);
        switch ($claimOrNo) {
            case 'claim':
                $data = $data->whereClaim("y");
                break;
            case 'customer':
                $data = $data->whereClaim("n");
                break;
        }
        $data = $data->whereDel("0")
            ->whereSUsed("1")
            ->with('toPDataOpl')
            ->get();
        $data = $data->map(function ($row) {
            $row->namaOpl = $row->toPDataOpl->nama_opl ?? '';
            $row->totalSebelumDiskon = $row->harga_satuan * $row->qty;
            $row->totalSetelahDiskon = $totalSetelahDiskon = ($row->harga_satuan * $row->qty) - $row->diskon_rp;
            $row->ppnOpl = round((10 / 100) * $totalSetelahDiskon);
            $row->totalHpp = $row->hpp * $row->qty;
            /* Jika claim n lakukan validasi, dan y tidak perlu lakukan validasi, karena semua datanya sdh penarikan by rumus class ini */
            if ($row->claim == "n") {
                $this->makeSureData($row->totalSetelahDiskon, $row->total, "Total Opl salah");
                $diskonPersenByRms = $this->getDiskonPersen($row->totalSebelumDiskon, $row->totalSetelahDiskon);
                // $this->makeSureData($diskonPersenByRms, $row->diskon, "idOpl {$row->id_detail_lain_wo} {$row->no_wo} Diskon persen Opl salah"); disable diskon opl
            }
            return $row;
        });
        return $data;
    }

    /**
     * getHppPart get hpp
     *
     * @param  mixed $kodeItem
     * @return int
     */
    private function getHppPart($kodeItem): int
    {
        $data = mItem::whereKodeItem($kodeItem)
            ->with([
                'toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian(2);
                }
            ])->get()->toArray();
        return $data[0]["to_p_class_item"][0]["discount"] ?? 0;
    }

    /**
     * getBiayaJasa menghitung biaya jasa sebelum diskon
     *
     * @param  mixed $jenisJasa enum ["customer","claim"]
     * @return int
     */
    private function getBiayaJasa($jenisJasa = null): array
    {
        $data = $this->queryJasa($jenisJasa);
        $result = [
            "sebelumDiskon" => $sebelumDiskon = $data->sum("totalSebelumDiskon"),
            "totalDiskon" => $diskonRp = $data->sum("diskon_rp"),
            "setelahDiskon" => $sebelumDiskon - $diskonRp,
        ];
        /* Jika Jenis jasa adalah customer, lakukan makesure data */
        if ($jenisJasa == "customer") {
            $this->makeSureData($result["setelahDiskon"], $this->dataWo[0]["total_biaya_jasa"], "Total biaya jasa salah");
        }
        return $result;
    }

    /**
     * getBiayaPart menghitung biaya part sebelum diskon
     *
     * @param  mixed $jenisPart enum ["customer","claim"]
     * @return int
     */
    private function getBiayaPart($jenisPart = null): array
    {
        $data = $this->queryPart($jenisPart);
        $result = [
            "sebelumDiskon" => $sebelumDiskon = $data->sum("totalSebelumDiskon"),
            "totalDiskon" => $diskonRp = $data->sum("diskon_rp"),
            "setelahDiskon" => $setelahDiskon = $sebelumDiskon - $diskonRp,
            "totalHpp" => $data->sum("hppTotal"),
            "totalOli" => $oliSetelahDiskon = $data->sum("biayaOliSetelahDiskon"),
            "totalPart" =>  $setelahDiskon - $oliSetelahDiskon /* tanpa jenis oli */
        ];
        /* Jika Jenis Part adalah customer, lakukan makesure data */
        if ($jenisPart == "customer") {
            $this->makeSureData($result["setelahDiskon"], $this->dataWo[0]["total_biaya_part"], "Total biaya part salah");
        }
        return $result;
    }

    private function getBiayaOpl($jenisOpl = null): array
    {
        $data = $this->queryOpl($jenisOpl);
        $result = [
            "sebelumDiskon" => $sebelumDiskon =  $data->sum("totalSebelumDiskon"),
            "totalDiskon" => $diskonRp = $data->sum("diskon_rp"),
            "setelahDiskon" => $sebelumDiskon - $diskonRp,
            "totalHpp" => $data->sum("hpp"),
        ];
        /* Jika Jenis Opl adalah customer, lakukan makesure data */
        if ($jenisOpl == "customer") {
            $this->makeSureData($result["setelahDiskon"], $this->dataWo[0]["total_biaya_lain"], "{$this->dataWo[0]["no_wo"]} Total biaya lain salah");
        }
        return $result;
    }

    private function getGrandTotaldanPpn($partSebelumDiskon, $diskonPart, $jasaSebelumDiskon, $diskonJasa, $oplSebelumDiskon, $diskonOpl)
    {
        return [
            "sebelumPpn" => $sebelumPpn = ($partSebelumDiskon - $diskonPart) + ($jasaSebelumDiskon - $diskonJasa) + ($oplSebelumDiskon - $diskonOpl),
            "ppn" => $ppn = round((10 / 100) * $sebelumPpn),
            "grandTotal" => $sebelumPpn + $ppn,
        ];
    }

    /**
     * getBiayaWo ambil biaya wo
     *
     * @return void
     */
    public function getBiayaWo()
    {
        switch ($this->jenisInvoice) {
            case 'claim':
                $this->biayaWo = [
                    "penjualanJasaBeforeDiskon" => $jasaSebelumDiskonClaim = $this->getBiayaJasa("claim")["sebelumDiskon"],
                    "diskonJasa" => $diskonJasaClaim = $this->getBiayaJasa("claim")["totalDiskon"],
                    "penjualanJasaAfterDiskon" => $jasaSebelumDiskonClaim - $diskonJasaClaim,

                    "penjualanOplBeforeDiskon" => $oplSebelumDiskonClaim = $this->getBiayaOpl("claim")["sebelumDiskon"],
                    "diskonOpl" => $diskonOplClaim = $this->getBiayaOpl("claim")["totalDiskon"],
                    "penjualanOplAfterDiskon" => $oplSebelumDiskonClaim - $diskonOplClaim,
                    "hppOpl" => $this->getBiayaOpl("claim")["totalHpp"],

                    "penjualanSparepartBeforeDiskon" => $partSebelumDiskonClaim = $this->getBiayaPart("claim")["sebelumDiskon"],
                    "diskonSparepart" => $diskonPartClaim = $this->getBiayaPart("claim")["totalDiskon"],
                    "penjualanSparepartAfterDiskon" => $partSebelumDiskonClaim - $diskonPartClaim,
                    "hppSparepart" => $this->getBiayaPart("claim")["totalHpp"],
                    "biayaOliAfterDiskon" => $this->getBiayaPart("claim")["totalOli"],
                    "biayaPartAfterDiskon" => $this->getBiayaPart("claim")["totalPart"], /* Part only without oli */

                    "totalDiskon" => $diskonJasaClaim + $diskonOplClaim + $diskonPartClaim,
                    'totalSebelumDiskon' => $jasaSebelumDiskonClaim + $partSebelumDiskonClaim + $oplSebelumDiskonClaim,
                    "sebelumPpn" => $this->getGrandTotaldanPpn($partSebelumDiskonClaim, $diskonPartClaim, $jasaSebelumDiskonClaim, $diskonJasaClaim, $oplSebelumDiskonClaim, $diskonOplClaim)['sebelumPpn'],
                    "totalPembayaran" => $totalPembayaran = $this->totalPembayaran(),
                    "grandTotal" => $grandTotal = $this->getGrandTotaldanPpn($partSebelumDiskonClaim, $diskonPartClaim, $jasaSebelumDiskonClaim, $diskonJasaClaim, $oplSebelumDiskonClaim, $diskonOplClaim)['grandTotal'],
                    "sisaAr" => $grandTotal - $totalPembayaran,
                    "ppn" => $this->getGrandTotaldanPpn($partSebelumDiskonClaim, $diskonPartClaim, $jasaSebelumDiskonClaim, $diskonJasaClaim, $oplSebelumDiskonClaim, $diskonOplClaim)['ppn'],
                    "ppnEfaktur" => $this->getPpnEfaktur(),
                ];
                break;
            case 'customer':
                $this->biayaWo = [
                    "penjualanJasaBeforeDiskon" => $jasaSebelumDiskonCustomer = $this->getBiayaJasa("customer")["sebelumDiskon"],
                    "diskonJasa" => $diskonJasaCustomer = $this->getBiayaJasa("customer")["totalDiskon"],
                    "penjualanJasaAfterDiskon" => $jasaSebelumDiskonCustomer - $diskonJasaCustomer,

                    "penjualanOplBeforeDiskon" => $oplSebelumDiskonCustomer = $this->getBiayaOpl("customer")["sebelumDiskon"],
                    "diskonOpl" => $diskonOplCustomer = $this->getBiayaOpl("customer")["totalDiskon"],
                    "penjualanOplAfterDiskon" => $oplSebelumDiskonCustomer - $diskonOplCustomer,
                    "hppOpl" => $this->getBiayaOpl("customer")["totalHpp"],

                    "penjualanSparepartBeforeDiskon" => $partSebelumDiskonCustomer = $this->getBiayaPart("customer")["sebelumDiskon"],
                    "diskonSparepart" => $diskonPartCustomer = $this->getBiayaPart("customer")["totalDiskon"],
                    "penjualanSparepartAfterDiskon" => $partSebelumDiskonCustomer - $diskonPartCustomer,
                    "hppSparepart" => $this->getBiayaPart("customer")["totalHpp"],
                    "biayaOliAfterDiskon" => $this->getBiayaPart("customer")["totalOli"],
                    "biayaPartAfterDiskon" => $this->getBiayaPart("customer")["totalPart"], /* Part only without oli */


                    "totalDiskon" => $diskonJasaCustomer + $diskonOplCustomer + $diskonPartCustomer,
                    'totalSebelumDiskon' => $jasaSebelumDiskonCustomer + $partSebelumDiskonCustomer + $oplSebelumDiskonCustomer,
                    "sebelumPpn" => $this->getGrandTotaldanPpn($partSebelumDiskonCustomer, $diskonPartCustomer, $jasaSebelumDiskonCustomer, $diskonJasaCustomer, $oplSebelumDiskonCustomer, $diskonOplCustomer)['sebelumPpn'],
                    "totalPembayaran" => $totalPembayaran = $this->totalPembayaran(),
                    "grandTotal" => $grandTotal = $this->getGrandTotaldanPpn($partSebelumDiskonCustomer, $diskonPartCustomer, $jasaSebelumDiskonCustomer, $diskonJasaCustomer, $oplSebelumDiskonCustomer, $diskonOplCustomer)['grandTotal'],
                    "sisaAr" => $grandTotal - $totalPembayaran,
                    "ppn" => $this->getGrandTotaldanPpn($partSebelumDiskonCustomer, $diskonPartCustomer, $jasaSebelumDiskonCustomer, $diskonJasaCustomer, $oplSebelumDiskonCustomer, $diskonOplCustomer)['ppn'],
                    "ppnEfaktur" => $this->getPpnEfaktur(),
                ];
                break;
            default:
                $this->biayaWo = [
                    "penjualanJasaBeforeDiskon" => $jasaSebelumDiskon =  $this->getBiayaJasa()["sebelumDiskon"],
                    "diskonJasa" => $diskonJasa = $this->getBiayaJasa()["totalDiskon"],
                    "penjualanJasaAfterDiskon" => $jasaSebelumDiskon - $diskonJasa,

                    "penjualanOplBeforeDiskon" => $oplSebelumDiskon = $this->getBiayaOpl()["sebelumDiskon"],
                    "diskonOpl" => $diskonOpl =  $this->getBiayaOpl()["totalDiskon"],
                    "hppOpl" => $this->getBiayaOpl()["totalHpp"],
                    "penjualanOplAfterDiskon" => $oplSebelumDiskon - $diskonOpl,

                    "penjualanSparepartBeforeDiskon" => $partSebelumDiskon = $this->getBiayaPart()["sebelumDiskon"],
                    "diskonSparepart" => $diskonPart = $this->getBiayaPart()["totalDiskon"],
                    "penjualanSparepartAfterDiskon" => $partSebelumDiskon - $diskonPart,
                    "hppSparepart" => $this->getBiayaPart()["totalHpp"],
                    "biayaOliAfterDiskon" => $this->getBiayaPart()["totalOli"],
                    "biayaPartAfterDiskon" => $this->getBiayaPart()["totalPart"], /* Part only without oli */

                    "totalDiskon" => $diskonJasa + $diskonOpl + $diskonPart,
                    'totalSebelumDiskon' => $jasaSebelumDiskon + $partSebelumDiskon + $oplSebelumDiskon,
                    "sebelumPpn" => $this->getGrandTotaldanPpn($partSebelumDiskon, $diskonPart, $jasaSebelumDiskon, $diskonJasa, $oplSebelumDiskon, $diskonOpl)['sebelumPpn'],
                    "totalPembayaran" => $totalPembayaran = $this->totalPembayaran(),
                    "grandTotal" => $grandTotal = $this->getGrandTotaldanPpn($partSebelumDiskon, $diskonPart, $jasaSebelumDiskon, $diskonJasa, $oplSebelumDiskon, $diskonOpl)['grandTotal'],
                    "sisaAr" => $grandTotal - $totalPembayaran,
                    "ppn" => $this->getGrandTotaldanPpn($partSebelumDiskon, $diskonPart, $jasaSebelumDiskon, $diskonJasa, $oplSebelumDiskon, $diskonOpl)['ppn'],
                    "ppnEfaktur" => $this->getPpnEfaktur(),
                ];
                break;
        }

        $this->makeSureData($this->biayaWo["ppn"], $this->biayaWo["ppnEfaktur"], "PPN Rumus, dan PPN Efaktur tidak sama");

        /* Jika no invoice tidak ada, tidak perlu lakukan validasi data buku besar */
        if (empty($this->noInvoice)) {
            null;
        } else {
            $this->makeSureInvIsReal();
            $this->makeSureBukuBesarJurnal();
        }
    }


    private function getPpnEfaktur()
    {
        $forSum[] = 0;
        foreach ($this->jasa as $row) {
            $forSum[] = $row["ppnJasa"];
        }
        foreach ($this->part as $row) {
            $forSum[] = $row["ppnPart"];
        }
        foreach ($this->opl as $row) {
            $forSum[] = $row["ppnOpl"];
        }

        return array_sum($forSum);
    }


    /**
     * makeSureData untuk make sure data antara rumus dan di database
     *
     * @param  mixed $rumus
     * @param  mixed $totalDb
     * @param  mixed $pesan
     * @return void
     */
    private function makeSureData($rumus, $totalDb, $pesan)
    {
        $selisih = $rumus - $totalDb;
        /* Jika selisih hanya 2 atau -2 tdk masalah, bisa di toleransi */
        if ($selisih > 2 || $selisih < -2) {
            throw new Exception("'{$pesan} {$this->noWo}' rms {$rumus} : db : {$totalDb}");
            die("'{$pesan}' rms {$rumus} : db : {$totalDb}");
        }
    }

    /**
     * getDiskonPersen get diskon persen
     *
     * @param  mixed $sebelumDiskon
     * @param  mixed $setelahDiskon
     * @return void
     */
    private function getDiskonPersen($sebelumDiskon, $setelahDiskon)
    {
        $diskonRp = $sebelumDiskon - $setelahDiskon;
        /* Jika diskon Rp.0, return diskon Persen 0% */
        if ($diskonRp  < 1) {
            return 0;
        } else {
            $diskonPersen = round(($diskonRp / $sebelumDiskon) * 100);
            return $diskonPersen;
        }
    }

    /**
     * makeSureInvIsReal untuk memastikan invoice valid
     *
     * @return void
     */
    private function makeSureInvIsReal()
    {
        $data = mBukuBesar::whereNoTransaksi($this->noInvoice)
            ->whereJb("0")->whereIn('journal', ['faktur_service', 'faktur_service_jurnalhpp']);
        $this->tglInvoice = $data->first()->tgl;
        /* Jika jurnal di bukubesar tidak 17 row, maka data fail */
        if ($data->count() != '17') {
            throw new Exception(
                "
                    No Invoice {$this->noInvoice} tidak ditemukan, atau
                    Kesalahan, No Inv {$this->noInvoice} pada buku besar 17 rows, tetapi {$data->count()},
                    Atau No Invoie Sdh Di Jurnal Balik.
                "
            );
        } else {
            /* Validasi no inv sdh ada apakah di wo status cetak sdh Y*/
            /* Kalau jenis customer */
            if ($this->jenisInvoice == "customer") {
                /* Cetak harus y */
                if ($this->dataWo[0]["cetak_invoice"] != "y") {
                    /* klo tidak mengandung huruf x buat fail */
                    if (strpos($this->noWo, 'x') !== true) {
                        throw new Exception("Kesalahan, {$this->noWo}, Inv {$this->noInvoice} sdh cetak inv, tetapi status cetak n");
                    }
                }
            }
        }
    }

    /**
     * jurnalBukuBesar jurnal bb by rumus
     *
     * @return void
     */
    private function jurnalBukuBesar()
    {
        $tahunInv = date("Y", strtotime("$this->tglInvoice"));
        /* Jika invoice terbit di atas tahun 2019 */
        if ($tahunInv > 2019) {
            /* gunakan coa hutang vendor lokal */
            $akun  = "210202";
        } else {
            /* gunakan coa persediaan lainnya */
            $akun  = "110890";
        }
        $jurnal = [
            "110403" => $this->biayaWo["grandTotal"],
            "450501" => $this->biayaWo["diskonJasa"],
            "450504" => $this->biayaWo["diskonOpl"],
            "450502" => $this->biayaWo["diskonSparepart"],
            "450503" => 0,
            "420101" => $this->biayaWo["penjualanJasaBeforeDiskon"],
            "420102" => $this->biayaWo["penjualanOplBeforeDiskon"],
            "420201" => $this->biayaWo["penjualanSparepartBeforeDiskon"],
            "420301" => 0,
            "210406" => $this->biayaWo["ppn"],
            "612003" => 0,
            "505201" => $this->biayaWo["hppSparepart"],
            "110801" => $this->biayaWo["hppSparepart"],
            "520301" => 0,
            "110802" => 0,
            "505102" => $this->biayaWo["hppOpl"],
            $akun => $this->biayaWo["hppOpl"]
        ];
        return $jurnal;
    }

    /**
     * makeSureBukuBesarJurnal validasi jurnal rumus dan jurnal di buku besar
     *
     * @return void
     */
    private function makeSureBukuBesarJurnal()
    {
        $nilaiByClass = $this->jurnalBukuBesar();
        // dd($jurnalByClass["110403"]);
        $bukuBesar = mBukuBesar::whereNoTransaksi($this->noInvoice)
            ->whereJb("0")->whereIn('journal', ['faktur_service', 'faktur_service_jurnalhpp'])->get();
        foreach ($bukuBesar->toArray() as $row) {
            $bb[$row["kode_akun"]] = $row["jumlah"];
        }
        // dd($bukuBesar);
        $kk = array_keys($bb);
        foreach ($kk as $kodeAkun) {
            try {
                $this->makeSureData(
                    $nilaiByClass[$kodeAkun],
                    $bb[$kodeAkun],
                    "{$kodeAkun} {$this->noInvoice} {$this->noWo}"
                );
            } catch (Exception $e) {
                /* Lepas Comment Untuk Maintenance, tetapi pastikan bahwa data di buku besar memang salah */
                // die("Something Wrong {$kodeAkun} {$this->noInvoice} {$this->noWo}, rms = {$nilaiByClass[$kodeAkun]} & bb = {$bb[$kodeAkun]}");
                /* Jalankan fungsi update nilai pada buku besar */
                $this->updateBukuBesar($kodeAkun, $this->noInvoice, $nilaiByClass[$kodeAkun]);
            }
        }

        /* Cek Balance Buku Besar */
        $this->cekBalanceBb($this->noInvoice);
    }

    /* Jangan panggil ini kecuali jika dalam maintenance | digunakan untuk update data buku besar yg salah*/
    private function updateBukuBesar($kodeAkun, $noInvoice, $jumlah)
    {
        mBukuBesar::whereNoTransaksi($noInvoice)
            ->whereJb("0")
            ->whereKodeModule("srvpart")
            ->whereKodeAkun($kodeAkun)
            ->update([
                "jumlah" => $jumlah,
            ]);
    }

    /* Validasi balance jurnal bb current */
    private function cekBalanceBb($noInvoice)
    {
        $data = mBukuBesar::whereNoTransaksi($noInvoice)
            ->whereJb("0")->get()->toArray();
        $debit = [];
        $kredit = [];
        foreach ($data as $row) {
            /* Tampung Debit */
            if ($row["dk"] == "D") {
                $debit[] = $row["jumlah"];
            }
            /* Tampung kredit */
            if ($row["dk"] == "K") {
                $kredit[] = $row["jumlah"];
            }
        }
        /*Cek balance */
        $this->makeSureData(
            array_sum($debit),
            array_sum($kredit),
            "Debit Kredit Fail"
        );
    }

    /* Validasi jika no Invoice adalah Wo */
    private function ifNoInvoiceWO()
    {
        $cekInvoiceAfterSales = mInvoiceAfterSales::whereNoRef($this->noInvoice);
        /* Cek apakah no wo yg menggunakan no inv masih no wo, apakah tidak ada no inv di inv after sales, kalau ada buat exception */
        if ($cekInvoiceAfterSales->count() > 0) {
            throw new Exception("No Inv {$this->noInvoice} menggunakan No Wo, tetapi di table invoice_after_sales, wo tersebut ada no invoicenya.");
        }

        /* JIka invoice tdk sama dengan no wo */
        if ($this->noInvoice != $this->noWo) {
            /* Jalankan cek no invoice retur atau tidak */
            $noRef = $cekInvoiceAfterSales->first()->no_ref ?? null;
            if (strpos($noRef, 'x') !== false) {
                throw new Exception("No Inv {$this->noInvoice} jika dicek di table invoice_after_sales, adalah wo retur, gunakan class retur untuk infomasi invoice ini");
            }
            if (strpos($this->noInvoice, 'RET-INV') !== false) {
                throw new Exception("No Inv {$this->noInvoice} jika dicek di table invoice_after_sales, adalah wo retur, gunakan class retur untuk infomasi invoice ini");
            }
        }
    }

    public function totalPembayaran()
    {
        $untukDiSum[] = 0;
        if (is_array($this->penerimaan)) {
            foreach ($this->penerimaan as $row) {
                $untukDiSum[] = $row["to_buku_besar"][0]["jumlah"] ?? '0';
            }
        }
        $totalPembayaran = array_sum($untukDiSum);
        return $totalPembayaran;
    }

    private function getPenerimaanAtPenerimaanBengelAlokasi($noRef)
    {
        $data = mPenerimaanBengkelAlokasi::with(
            [
                "toPenerimaanBengkel",
                "toBukuBesar" => function ($query) {
                    $query->whereJb("0");
                    $query->whereKodeAkun("110403");
                    $query->whereDk("K");
                }
            ]
        )->whereNoRef($noRef)->get();
        $data = $data->map(function ($row) {
            $row->no_penerimaan = $row->toPenerimaanBengkel->no_penerimaan;
            $row->tgl = $row->toPenerimaanBengkel->tgl;
            $row->no_ref = $row->no_ref;
            $row->jenis_bayar = $row->toPenerimaanBengkel->jenis_bayar;
            $row->subgolongan = $row->toPenerimaanBengkel->subgolongan;
            $row->akun_subgolongan = $row->toPenerimaanBengkel->akun_subgolongan;
            $row->id_bank = $row->toPenerimaanBengkel->id_bank;
            $row->total = $row->jumlah_alokasi;
            $row->journal = $row->toPenerimaanBengkel->journal;
            $row->keterangan = $row->toPenerimaanBengkel->keterangan;
            $row->id_perusahaan = $row->toPenerimaanBengkel->id_perusahaan;
            $row->w_insert = $row->toPenerimaanBengkel->w_insert;
            $row->w_update = $row->toPenerimaanBengkel->w_update;
            $row->user = $row->toPenerimaanBengkel->user;
            $row->posting = $row->toPenerimaanBengkel->posting;
            $row->no_wo = $row->toPenerimaanBengkel->no_wo;
            $row->kk_no_ref = $row->toPenerimaanBengkel->kk_no_ref;
            $row->kk_no_penerimaan = $row->toPenerimaanBengkel->kk_no_penerimaan;
            $row->kk_selisih = $row->toPenerimaanBengkel->kk_selisih;
            $row->diterima = $row->toPenerimaanBengkel->diterima;
            $row->jenis_transaksi = $row->toPenerimaanBengkel->jenis_transaksi;
            $row->status_cek_audit = $row->toPenerimaanBengkel->status_cek_audit;
            $row->toBukuBesar->map(function ($rowBukuBesar) use ($row) {
                $rowBukuBesar->jumlah = $row->jumlah_alokasi;
                return $rowBukuBesar;
            });
            return $row;
        });
        return $data;
    }


    public function getPenerimaan()
    {
        $data = mPenerimaanBengkel::whereNoRef($this->noInvoice)
            ->whereIn("jenis_bayar", ["t", "tf"])
            ->with([
                "toBukuBesar" => function ($query) {
                    $query->whereJb("0");
                    $query->whereKodeAkun("110403");
                    $query->whereDk("K");
                }
            ])->orderBy('tgl', 'desc')->get();
        $getPenerimaanAtPenerimaanBengelAlokasi = $this->getPenerimaanAtPenerimaanBengelAlokasi($this->noInvoice)->toArray();
        $listPenerimaan = array_merge($data->toArray(), $getPenerimaanAtPenerimaanBengelAlokasi);
        $this->penerimaan = $listPenerimaan;
    }

    public function getAmbilSemuaDataOtomatis()
    {
        return $this->ambilSemuaDataOtomatis;
    }

    public function setAmbilSemuaDataOtomatis($ambilSemuaDataOtomatis)
    {
        $this->ambilSemuaDataOtomatis = $ambilSemuaDataOtomatis;
        return $this;
    }


    public function getSisaArByKasir()
    {
        return $this->sisaArByKasir;
    }


    public function setSisaArByKasir($noPenerimaan, $noRef, $nilaiInv)
    {
        $tgl = mPenerimaanBengkel::select("tgl")->whereNoPenerimaan($noPenerimaan)->first();
        $daftarPenerimaan = mPenerimaanBengkel::whereHas("toBukuBesar", function ($query) {
            $query->whereJb("0")
                ->whereKodeAkun("110403");
        })
            ->whereNoRef($noRef)
            ->whereDate("tgl", "<=", $tgl->tgl)
            ->whereIn("jenis_bayar", ["t", "tf"])
            ->get()->sum("total");
        $sisaAr = $nilaiInv - $daftarPenerimaan;
        $this->sisaArByKasir = $sisaAr;
        return $this;
    }
}
