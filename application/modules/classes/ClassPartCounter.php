<?php

namespace app\modules\classes;

use app\modules\elo_models\honda_sp\mItem;
use app\modules\elo_models\honda\mBukuBesar;
use Illuminate\Database\Capsule\Manager as DB;
use app\modules\elo_models\honda\mNomorEFaktur;
use app\modules\elo_models\honda_sp\mPelanggan;
use app\modules\elo_models\honda_sp\mPenjualan;
use app\modules\elo_models\honda\mPenerimaanBengkel;
use app\modules\elo_models\honda_sp\mPesananPenjualan;
use app\modules\elo_models\honda_as\mInvoiceAfterSales;

if (!defined('BASEPATH')) exit('No direct script access allowed');
class ClassPartCounter extends \MX_Controller
{
    var $noSo;
    var $noInvoice;
    public $tglInvoice;
    public $customer;
    public $order;
    public $itemsOrder;
    public $biaya;
    public $jurnal;
    public $namaSales;
    public $penerimaan;
    public $noFaktur;
    public $sisaArByKasir;


    /**
     * setNoSo
     *
     * @param  mixed $noSo No transaksi
     * @return void
     */
    public function setNoSo($noSo)
    {
        $this->noSo =  $noSo;
    }

    public function setNoInvoiceByNoSo($noSo)
    {
        $noInvoice = mInvoiceAfterSales::whereNoRef($noSo);
        if ($noInvoice->count() > 0) {
            $this->setNoInvoice($noInvoice->first()->no_invoice);
        }
    }

    /**
     * setOrder
     *
     * @return void
     */
    public function setOrder()
    {
        $data = mPesananPenjualan::whereNoTransaksi($this->noSo)->with('toKaryawan')->first();
        /* is no so ada, jika tidak lakukan die, karena no inv ada, maka no so jg harus ada*/
        if (empty($data)) {
            die("Fail, no inv {$this->noInvoice}, no order {$this->noSo}, data tidak ditemukan");
        }
        $this->order = $data->toArray();
    }

    /**
     * setCustomer 
     *
     * @return void
     */
    public function setCustomer()
    {
        DB::beginTransaction();
        $data = mPelanggan::whereKodePelanggan($this->order["kode_pelanggan"])->first();
        /* jika kode pelanggan tdk ada create data pelanggan */
        if (empty($data)) {
            /* Jika pelanggan kosong buat data pelanggan baru */
            $this->createPelanggan($this->order["kode_pelanggan"]);

            /* panggil ulang query kode pelanggan */
            $data = mPelanggan::whereKodePelanggan($this->order["kode_pelanggan"])->first();
            /* jika pelanggan masih tidak ada, lakukan die */
            if (empty($data)) {
                die("Fail Kode pelanggan {$this->order["kode_pelanggan"]}, sdh di generate oleh sistem, tetapi gagal menyimpan");
            }
        }
        $this->customer = $data->toArray();
        DB::commit();
    }

    /**
     * createPelanggan insert data ke table pelanggan menggunakan kode pelanggan
     *
     * @param  mixed $kodePelanggan
     * @return void
     */
    private function createPelanggan($kodePelanggan)
    {
        $pelanggan = new mPelanggan;
        $pelanggan->id_perusahaan  = $this->session->userdata('id_perusahaan');
        $pelanggan->nama_pelanggan = "-";
        $pelanggan->alamat = "-";
        $pelanggan->kota = "-";
        $pelanggan->keterangan = "Generate By Sistem";
        $pelanggan->kode_pelanggan = $kodePelanggan;
        $pelanggan->admin = "0402109"; /* Nik AndiChaerul */
        $pelanggan->save();
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
        $this->getNoSoByNoInvoice();
        $this->setPenerimaan();
        $this->setOrder();
        $this->setCustomer();
        $this->setItems();
        $this->setJurnal();
        $this->tglInvoice = $this->queryBukuBesar()->first()->tgl;
    }

    public function setItems()
    {
        $idPesananPenjualan = $this->order["id_pesanan_penjualan"];
        $data = $this->queryItemsOrder($idPesananPenjualan);
        $this->itemsOrder =  $data->toArray();
        $this->biaya();
        $this->validasiTotalItem();
        $this->validasiTotalAkhir();
    }

    /**
     * getNoSoByNoInvoice
     *
     * @return void
     */
    private function getNoSoByNoInvoice()
    {
        $noSo = mInvoiceAfterSales::whereNoInvoice($this->noInvoice)->first()->no_ref ?? '';
        $this->validasiInvIsReal();
        $this->noSo = $noSo;
    }

    /**
     * biaya
     *
     * @return void
     */
    private function biaya()
    {
        $idPesananPenjualan = $this->order["id_pesanan_penjualan"];
        $this->biaya = [
            "totalPenerimaan" => $totalPenerimaan = $this->totalPenerimaan(),
            "totalHpp" => $beforeDiskon = $this->queryItemsOrder($idPesananPenjualan)->sum("hppSatuan"),
            "beforeDiskon" => $beforeDiskon = $this->queryItemsOrder($idPesananPenjualan)->sum("totalKaliQty"),
            "diskon" => $diskon = $this->order["diskon"],
            "ongkir" => $ongkir = $this->order["ongkir_rp"],
            "afterDiskon" => $afterDiskonDanOngkir = ($beforeDiskon - $diskon) + $ongkir,
            "oli" => $oli = $this->queryItemsOrder($idPesananPenjualan)->sum("biayaOliSetelahDiskon"),
            "part" => $afterDiskonDanOngkir - $oli, /* only part, without oli */
            "ppn" => $ppn = round((10 / 100) * $afterDiskonDanOngkir),
            "grandTotal" => $grandTotal = $afterDiskonDanOngkir + $ppn,
            "sisaAr" => $grandTotal - $totalPenerimaan,
            "diskonPersen" => $this->cariDiskonPersen($beforeDiskon, $diskon),
        ];
        // dd($diskon, $beforeDiskon, $ppn, $ongkir, $grandTotal);
        /* hanya memvalidasi nilai bb jika no invoice di set */
        if (!empty($this->noInvoice)) {
            $this->validasiNilaiBukuBesar();
        }
    }

    private function cariDiskonPersen($beforeDiskon, $diskonRp)
    {
        $result = ($diskonRp / $beforeDiskon) * 100;
        return round($result);
    }

    private function totalPenerimaan()
    {
        $forSum[] = 0;
        foreach ($this->penerimaan as $row) {
            if (count($row["to_buku_besar"]) > 0) {
                $forSum[] = $row["to_buku_besar"][0]["jumlah"];
            }
        }
        return array_sum($forSum);
    }

    /**
     * validasiNilaiBukuBesar
     *
     * @return void
     */
    private function validasiNilaiBukuBesar()
    {
        $query = $this->queryBukuBesar()->get()->toArray();
        foreach ($query as $row) {
            switch ($row["kode_akun"]) {
                case '110404':/* Grandtotal */
                    $this->makeSureData($this->biaya["grandTotal"], $row["jumlah"], "Buku besar {$this->noInvoice} | {$this->noSo} {$row["kode_akun"]} tidak sama");
                    break;
                case '420202':/* Subtotal before diskon */
                    $this->makeSureData($this->biaya["beforeDiskon"], $row["jumlah"], "Buku besar {$this->noInvoice} | {$this->noSo} {$row["kode_akun"]} tidak sama");
                    break;
                case '210406':/* PPN */
                    $this->makeSureData($this->biaya["ppn"], $row["jumlah"], "Buku besar {$this->noInvoice} | {$this->noSo} {$row["kode_akun"]} tidak sama");
                    break;
                case '450502':/* Diskon */
                    $this->makeSureData($this->biaya["diskon"], $row["jumlah"], "Buku besar {$this->noInvoice} | {$this->noSo} {$row["kode_akun"]} tidak sama");
                    break;
            }
        }
    }




    /**
     * makeSureData
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
            die("'{$pesan} ' rms {$rumus} : db : {$totalDb}");
        }
    }


    /**
     * validasiInvIsReal
     *
     * @return void
     */
    private function validasiInvIsReal()
    {
        $cekDiBukuBesar = $this->queryBukuBesar();
        $cekDiInvAfterSales = mInvoiceAfterSales::whereNoInvoice($this->noInvoice);
        /* jika jurnal bkn empat/lima berarti ada kesalahan jurnal yg terbentuk */
        // if ($cekDiBukuBesar->count() != 6) {
        //     // die("Invoice tidak valid, not 4 rows {$this->noInvoice} | {$this->noSo}");
        //     if ($cekDiBukuBesar->count() != 7) {
        //         die("Invoice tidak valid, not 6 or 7 rows {$this->noInvoice} | {$this->noSo}"); //Jurnal salah cek buku besar
        //     }
        // };
        /* JIka no inv tdk ada di db invoice after sales lakukan die */
        if ($cekDiInvAfterSales->count() != 1) {
            die("Invoice {$this->noInvoice} tdk ditemukan pada db invAfterSales");
        }
    }


    /**
     * validasiTotalItem
     *
     * @return void
     */
    private function validasiTotalItem()
    {
        $totalItemDB = $this->order["total_item"];
        foreach ($this->itemsOrder as $row) {
            $untukArraySum[] = $row["qty"];
        }
        $totalItemRumus = array_sum($untukArraySum);
        $this->makeSureData($totalItemRumus, $totalItemDB, "Total item {$this->noSo} tidak sama");
    }

    /**
     * validasiTotalAkhir
     *
     * @return void
     */
    private function validasiTotalAkhir()
    {
        $totalAkhirDB = $this->order["total_akhir"];
        $beforeDiskon = $this->biaya["beforeDiskon"];
        $diskon = $this->order["diskon"];
        $ongkir = $this->order["ongkir_rp"];
        $afterDiskon = ($beforeDiskon - $diskon) + $ongkir;
        $ppnRumus = $this->biaya["ppn"];
        $this->makeSureData($ppnRumus, $this->order["pajak"], "PPN {$this->noSo} Tidak sama");
        $totalAkhirRumus = $afterDiskon + $ppnRumus;
        $this->makeSureData($totalAkhirRumus, $totalAkhirDB, "Total akhir {$this->noSo}  tidak sama");
    }

    /**
     * queryItemsOrder
     *
     * @param  mixed $idPesananPenjualan
     * @return object
     */
    private function queryItemsOrder($idPesananPenjualan)
    {
        $data = mPenjualan::with("toItem", "toPesananPenjualan")->whereIdPesananPenjualan($idPesananPenjualan)
            ->where("qty", ">", "0")
            ->get();

        foreach ($data->toArray() as $key => $value) {
            $forSumMencariTotal[] = $value["harga_jual"] * $value["qty"];
        }

        $beforeDiskon = array_sum($forSumMencariTotal ?? [0]);
        $data = $data->map(function ($row) use ($beforeDiskon) {
            $hppDiskonPersen = $this->getHppPart($row->kode_item);
            $hppDiskonRp = round(($hppDiskonPersen / 100) * $row->harga_jual);
            $row->hppSatuan = $row->harga_jual - $hppDiskonRp;
            $row->totalKaliQty = $row->harga_jual * $row->qty;
            $row->diskonPersen = $this->cariDiskonPersen($beforeDiskon, $row->toPesananPenjualan->diskon);
            $row->diskonRp = ($row->diskonPersen / 100) * $row->totalKaliQty;
            $row->dpp = $totalSetelahDiskon =  $row->totalKaliQty - $row->diskonRp; /* after diskon */
            /* Cari Nilai Oli */
            if (strpos($row->toItem->nama_item, 'OIL') !== false && $row->toItem->jenis_item != "part") { /* Jikan nama item mengadung oli atau jenis item adalah part */
                $row->biayaOliSetelahDiskon = $totalSetelahDiskon;
            } else {
                $row->biayaOliSetelahDiskon = 0;
            }
            $row->ppn = (10 / 100) * $row->dpp;
            return $row;
        });
        return $data;
    }


    /**
     * queryBukuBesar
     *
     * @return object
     */
    private function queryBukuBesar()
    {
        return mBukuBesar::whereNoTransaksi($this->noInvoice);
    }

    /**
     * getHppPart
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
     * setJurnal
     *
     * @return void
     */
    public function setJurnal()
    {
        $this->jurnal = [
            "110404" => $this->biaya["grandTotal"],
            "450502" => $this->biaya["diskon"],
            "420202" => $this->biaya["beforeDiskon"],
            "210406" => $this->biaya["ppn"],
        ];
    }

    public function setPenerimaan()
    {
        $data = mPenerimaanBengkel::whereIn("no_ref", [$this->noInvoice, $this->noSo])
            ->whereIn("jenis_bayar", ["t", "tf"])
            ->with([
                "toBukuBesar" => function ($query) {
                    $query->whereKodeAkun("110404");
                    $query->whereDk("K");
                    $query->whereJb("0");
                }
            ])
            ->get();
        $this->penerimaan = $data->toArray();
    }

    public function getNoFaktur()
    {
        return $this->noFaktur;
    }

    public function setNoFaktur()
    {
        $data = mNomorEFaktur::whereNoTransaksi($this->noInvoice)->first();
        if ($data) {
            $this->noFaktur = $data->toArray();
        }
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
