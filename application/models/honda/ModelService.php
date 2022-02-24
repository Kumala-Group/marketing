<?php

namespace app\models\honda;

use app\libraries\Capsule;
use app\libraries\Datatable;
use app\modules\elo_models\honda\mBukuBesar;
use app\modules\elo_models\honda_as\mEstimasi;
use app\modules\elo_models\honda_as\mWorkOrder;

class ModelService
{
    private static $joins   = [];
    private static $columns = [];
    private static $filters = [];
    private static $selects = [];
    private static $orderBy;

    private static $noWo;
    private static $jenisWo;
    private static $tanggal;
    private static $noInvoice;
    private static $noEstimasi;
    private static $perusahaan;
    private static $jenisInvoice;

    private static $allDetail = FALSE;
    private static $nilaiReal = FALSE;
    private static $periodeTanggal = [];

    private $datatable;

    private $query;
    private $results;
    private $resultsDatatable;

    public function __construct()
    {
        new Capsule;
        $this->datatable = new Datatable;
    }

    public static function setTanggal($tanggal)
    {
        static::$tanggal = $tanggal;
        return new static;
    }

    public static function setPeriodeTanggal($awal, $akhir)
    {
        static::$periodeTanggal = [$awal, $akhir];
        return new static;
    }

    public static function setPerusahaan($perusahaan)
    {
        static::$perusahaan = $perusahaan;
        return new static;
    }

    public static function setJenisInvoice($jenisInvoice)
    {
        static::$jenisInvoice = $jenisInvoice;
        return new static;
    }

    public static function setJenisWo($jenisWo)
    {
        static::$jenisWo = $jenisWo;
        return new static;
    }

    public static function setAllDetail(bool $allDetail)
    {
        static::$allDetail = $allDetail;
        return new static;
    }

    public static function setNilaiReal(bool $nilaiReal)
    {
        static::$nilaiReal = $nilaiReal;
        return new static;
    }

    public static function setNoInvoice($noInvoice)
    {
        static::$noInvoice = $noInvoice;
        return new static;
    }

    public static function setNoWo($noWo)
    {
        static::$noWo = $noWo;
        return new static;
    }

    public static function setNoEstimasi($noEstimasi)
    {
        static::$noEstimasi = $noEstimasi;
        return new static;
    }

    public static function setColumns()
    {
        static::$columns = func_get_args();
        return new static;
    }

    public static function addSelects()
    {
        static::$selects = func_get_args();
        return new static;
    }

    public static function addJoins()
    {
        static::$joins = func_get_args();
        return new static;
    }

    public static function addFilters()
    {
        static::$filters = func_get_args();
        return new static;
    }

    public static function setOrderBy(string $orderBy)
    {
        static::$orderBy = $orderBy;
        return new static;
    }

    public function get($jenis = NULL)
    {
        $this->setQuery($jenis);
        $this->getResults($jenis);
        return $this->results;
    }

    public function getDatatable($jenis = NULL)
    {
        $this->setQuery($jenis);
        $this->getResultsDatatable($jenis);
        return $this->resultsDatatable;
    }

    private function setQuery($jenis = NULL)
    {
        if ($jenis === 'estimasi') {
            $this->query = mEstimasi::with([
                'toPKategoriWo',
                'toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('210603')->whereDk('K')->whereJb('0');
                },
                'toCustomer',
                'toDetailUnitCustomer.toUnit.toPWarna',
                'toDetailUnitCustomer.toUnit.toPModel',
                'toUser.toKaryawan.toKodeSa',
                'toPaket' => function ($query) {
                    $query->whereDel('0');
                },
                'toPaket.toPaketMaster.toSvcatCode',
                'toDetailJasa' => function ($query) {
                    $query->whereDel('0');
                },
                'toDetailJasa.toJasa.toPNamaJasa',
                'toDetailPart' => function ($query) {
                    $query->whereDel('0');
                },
                'toDetailPart.toItem.toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian('2');
                },
                'toDetailOpl' => function ($query) {
                    $query->whereDel('0');
                },
            ]);
            if (!empty(static::$selects)) {
                $selects = implode(',', static::$selects);
                $this->query = $this->query->selectRaw($selects);
            }
            if (!empty(static::$joins)) {
                foreach (static::$joins as $key => $value) {
                    if ($value[0] === 'left') {
                        $this->query = $this->query->leftJoin($value[1], $value[2], $value[3], $value[4]);
                    } else {
                        $this->query = $this->query->join($value[0], $value[1], $value[2], $value[3]);
                    }
                }
            }
            if (!empty(static::$filters)) {
                foreach (static::$filters as $key => $value) {
                    if (is_array($value)) {
                        $this->query = $this->query->where($value[0], $value[1], $value[2]);
                    } else {
                        $this->query = $this->query->whereRaw($value);
                    }
                }
            }
            if (!empty(static::$tanggal)) {
                $this->query = $this->query->whereDate('estimasi.tgl_service', '=', static::$tanggal);
            }
            if (!empty(static::$periodeTanggal)) {
                $this->query = $this->query->whereBetween('estimasi.tgl_service', static::$periodeTanggal);
            }
            if (!empty(static::$perusahaan)) {
                $this->query = $this->query->where('estimasi.id_perusahaan', '=', static::$perusahaan);
            }
            if (!empty(static::$noEstimasi)) {
                if (is_array(static::$noEstimasi)) {
                    $this->query = $this->query->whereIn('estimasi.no_estimasi', static::$noEstimasi);
                } else {
                    $this->query = $this->query->where('estimasi.no_estimasi', '=', static::$noEstimasi);
                }
            }
            if (!empty(static::$orderBy)) {
                $this->query = $this->query->orderByRaw(static::$orderBy);
            }
        } elseif ($jenis === 'workOrder') {
            $this->query = mWorkOrder::with([
                'toBukuBesarByWo' => function ($query) {
                    $query->whereIn('journal', ['faktur_service', 'faktur_service_jurnalhpp'])->whereJb('0');
                },
                'toBukuBesarByWo.toNomorEFaktur',
                'toBukuBesarByWo.toPenerimaanBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"]);
                },
                'toBukuBesarByWo.toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereIn('kode_akun', ['110403', '210603'])->whereDk('K')->whereJb('0'); //get sisa AR DP WO di penerimaan bengkel
                },
                'toBukuBesarByWo.toPengeluaranBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"])->whereApproved('1')->whereHapus('0');
                },
                'toBukuBesarByWo.toPengeluaranBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('110403')->whereDk('D')->whereJb('0');
                },
                'toInvoiceAfterSales' => function ($query) {
                    $query->whereInvoiceBatal('0')->where('no_invoice', 'not like', 'INV-WO-CLM.%');
                },
                'toInvoiceAfterSales.toBukuBesar' => function ($query) {
                    $query->whereIn('journal', ['faktur_service', 'faktur_service_jurnalhpp'])->whereJb('0');
                },
                'toInvoiceAfterSales.toBukuBesar.toNomorEFaktur',
                'toInvoiceAfterSales.toBukuBesar.toPenerimaanBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"]);
                },
                'toInvoiceAfterSales.toBukuBesar.toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereIn('kode_akun', ['110403', '210603'])->whereDk('K')->whereJb('0'); //get sisa AR DP WO di penerimaan bengkel
                },
                'toInvoiceAfterSales.toBukuBesar.toPengeluaranBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"])->whereApproved('1')->whereHapus('0');
                },
                'toInvoiceAfterSales.toBukuBesar.toPengeluaranBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('110403')->whereDk('D')->whereJb('0');
                },
                'toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('210603')->whereDk('K')->whereJb('0');
                },
                'toEstimasi.toPKategoriWo',
                'toEstimasi.toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('210603')->whereDk('K')->whereJb('0');
                },
                'toCustomer',
                'toDetailUnitCustomer.toUnit.toPWarna',
                'toDetailUnitCustomer.toUnit.toPModel',
                'toUser.toKaryawan.toKodeSa',
                'toPaket' => function ($query) {
                    if (!empty(static::$jenisWo)) {
                        if (static::$jenisWo === 'claim') {
                            $query->whereClaim('y');
                        } elseif (static::$jenisWo === 'customer') {
                            $query->whereClaim('n');
                        }
                    }
                    $query->whereDel('0');
                },
                'toPaket.toPaketMaster.toSvcatCode',
                'toPaket.toPaketProgress.toKaryawan.toLevelMekanik',
                'toDetailJasa' => function ($query) {
                    if (!empty(static::$jenisWo)) {
                        if (static::$jenisWo === 'claim') {
                            $query->whereClaim('y');
                        } elseif (static::$jenisWo === 'customer') {
                            $query->whereClaim('n');
                        }
                    }
                    $query->whereDel('0');
                },
                'toDetailJasa.toJasa.toPNamaJasa',
                'toDetailJasa.toHistoryProgressJasaArray.toKaryawan.toLevelMekanik',
                'toDetailPart' => function ($query) {
                    if (!empty(static::$jenisWo)) {
                        if (static::$jenisWo === 'claim') {
                            $query->whereClaim('y');
                        } elseif (static::$jenisWo === 'customer') {
                            $query->whereClaim('n');
                        }
                    }
                    $query->whereDel('0');
                },
                'toDetailPart.toItem.toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian('2');
                },
                'toDetailPart.toKaryawan.toLevelMekanik',
                'toDetailOpl' => function ($query) {
                    if (!empty(static::$jenisWo)) {
                        if (static::$jenisWo === 'claim') {
                            $query->whereClaim('y');
                        } elseif (static::$jenisWo === 'customer') {
                            $query->whereClaim('n');
                        }
                    }
                    $query->whereDel('0');
                },
                'toDetailOpl.toPDataOpl.toVendor',
                'toDetailOpl.toKaryawan'
            ]);
            if (!empty(static::$selects)) {
                $selects = implode(',', static::$selects);
                $this->query = $this->query->selectRaw($selects);
            }
            if (!empty(static::$joins)) {
                foreach (static::$joins as $key => $value) {
                    if ($value[0] === 'left') {
                        $this->query = $this->query->leftJoin($value[1], $value[2], $value[3], $value[4]);
                    } else {
                        $this->query = $this->query->join($value[0], $value[1], $value[2], $value[3]);
                    }
                }
            }
            if (!empty(static::$filters)) {
                foreach (static::$filters as $key => $value) {
                    if (is_array($value)) {
                        $this->query = $this->query->where($value[0], $value[1], $value[2]);
                    } else {
                        $this->query = $this->query->whereRaw($value);
                    }
                }
            }
            if (!empty(static::$tanggal)) {
                $this->query = $this->query->whereDate('work_order.tgl_service', '=', static::$tanggal);
            }
            if (!empty(static::$periodeTanggal)) {
                $this->query = $this->query->whereBetween('work_order.tgl_service', static::$periodeTanggal);
            }
            if (!empty(static::$perusahaan)) {
                $this->query = $this->query->where('work_order.id_perusahaan', '=', static::$perusahaan);
            }
            if (!empty(static::$noWo)) {
                if (is_array(static::$noWo)) {
                    $this->query = $this->query->whereIn('work_order.no_wo', static::$noWo);
                } else {
                    $this->query = $this->query->where('work_order.no_wo', '=', static::$noWo);
                }
            }
            if (!empty(static::$orderBy)) {
                $this->query = $this->query->orderByRaw(static::$orderBy);
            }
        } else {
            $this->query = mBukuBesar::with([
                'toNomorEFaktur',
                'toBukuBesar' => function ($query) {
                    $query->whereIn('journal', ['faktur_service', 'faktur_service_jurnalhpp']);
                },
                'toPenerimaanBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"]);
                },
                'toPenerimaanBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereIn('kode_akun', ['110403', '210603'])->whereDk('K')->whereJb('0');
                },
                'toPengeluaranBengkelNoRef' => function ($query) {
                    $query->whereIn("jenis_bayar", ["t", "tf"])->whereApproved('1')->whereHapus('0');
                },
                'toPengeluaranBengkelNoRef.toBukuBesar' => function ($query) {
                    $query->whereKodeAkun('110403')->whereDk('D')->whereJb('0');
                },
                'toUser.toKaryawan',
                //toWorkOrderNoInv
                'toWorkOrderNoInv.toEstimasi.toLokasiService',
                'toWorkOrderNoInv.toCustomer',
                'toWorkOrderNoInv.toDetailUnitCustomer.toUnit.toPWarna',
                'toWorkOrderNoInv.toDetailUnitCustomer.toUnit.toPModel',
                'toWorkOrderNoInv.toUser.toKaryawan.toKodeSa',
                'toWorkOrderNoInv.toPaket' => function ($query) {
                    $query->whereDel('0');
                },
                'toWorkOrderNoInv.toPaket.toPaketMaster.toSvcatCode',
                'toWorkOrderNoInv.toPaket.toPaketProgress.toKaryawan.toLevelMekanik',
                'toWorkOrderNoInv.toDetailJasa' => function ($query) {
                    $query->whereDel('0');
                },
                'toWorkOrderNoInv.toDetailJasa.toJasa.toPNamaJasa',
                'toWorkOrderNoInv.toDetailJasa.toHistoryProgressJasaArray.toKaryawan.toLevelMekanik',
                'toWorkOrderNoInv.toDetailPart' => function ($query) {
                    $query->whereDel('0');
                },
                'toWorkOrderNoInv.toDetailPart.toItem.toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian('2');
                },
                'toWorkOrderNoInv.toDetailPart.toKaryawan.toLevelMekanik',
                'toWorkOrderNoInv.toDetailOpl' => function ($query) {
                    $query->whereDel('0');
                },
                'toWorkOrderNoInv.toDetailOpl.toPDataOpl.toVendor',
                'toWorkOrderNoInv.toDetailOpl.toKaryawan',
                //toWorkOrderNoRef
                'toInvoiceAfterSalesArray.toWorkOrder.toHutangVendorLokal' => function ($query) {
                    $query->whereStatus('0');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toHutangVendorLokal.toBukuBesar',
                'toInvoiceAfterSalesArray.toWorkOrder.toEstimasi.toLokasiService',
                'toInvoiceAfterSalesArray.toWorkOrder.toCustomer',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailUnitCustomer.toUnit.toPWarna',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailUnitCustomer.toUnit.toPModel',
                'toInvoiceAfterSalesArray.toWorkOrder.toUser.toKaryawan.toKodeSa',
                'toInvoiceAfterSalesArray.toWorkOrder.toPaket' => function ($query) {
                    if (!empty(static::$noInvoice)) {
                        if (!is_array(static::$noInvoice)) {
                            if (strpos(static::$noInvoice, 'INV-WO-CLM.') !== FALSE) {
                                $query->whereClaim('y');
                            } elseif (strpos(static::$noInvoice, 'INV-WO.') !== FALSE) {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    if (static::$allDetail !== TRUE) {
                        if (!empty(static::$jenisInvoice)) {
                            if (static::$jenisInvoice === 'claim') {
                                $query->whereClaim('y');
                            } elseif (static::$jenisInvoice === 'customer') {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    $query->whereDel('0');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toPaket.toPaketMaster.toSvcatCode',
                'toInvoiceAfterSalesArray.toWorkOrder.toPaket.toPaketProgress.toKaryawan.toLevelMekanik',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailJasa' => function ($query) {
                    if (!empty(static::$noInvoice)) {
                        if (!is_array(static::$noInvoice)) {
                            if (strpos(static::$noInvoice, 'INV-WO-CLM.') !== FALSE) {
                                $query->whereClaim('y');
                            } elseif (strpos(static::$noInvoice, 'INV-WO.') !== FALSE) {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    if (static::$allDetail !== TRUE) {
                        if (!empty(static::$jenisInvoice)) {
                            if (static::$jenisInvoice === 'claim') {
                                $query->whereClaim('y');
                            } elseif (static::$jenisInvoice === 'customer') {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    $query->whereDel('0');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailJasa.toJasa.toPNamaJasa',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailJasa.toHistoryProgressJasaArray.toKaryawan.toLevelMekanik',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailPart' => function ($query) {
                    if (!empty(static::$noInvoice)) {
                        if (!is_array(static::$noInvoice)) {
                            if (strpos(static::$noInvoice, 'INV-WO-CLM.') !== FALSE) {
                                $query->whereClaim('y');
                            } elseif (strpos(static::$noInvoice, 'INV-WO.') !== FALSE) {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    if (static::$allDetail !== TRUE) {
                        if (!empty(static::$jenisInvoice)) {
                            if (static::$jenisInvoice === 'claim') {
                                $query->whereClaim('y');
                            } elseif (static::$jenisInvoice === 'customer') {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    $query->whereDel('0');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailPart.toItem.toPClassItem' => function ($query) {
                    $query->whereIdKategoriPembelian('2');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailPart.toKaryawan.toLevelMekanik',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailOpl' => function ($query) {
                    if (!empty(static::$noInvoice)) {
                        if (!is_array(static::$noInvoice)) {
                            if (strpos(static::$noInvoice, 'INV-WO-CLM.') !== FALSE) {
                                $query->whereClaim('y');
                            } elseif (strpos(static::$noInvoice, 'INV-WO.') !== FALSE) {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    if (static::$allDetail !== TRUE) {
                        if (!empty(static::$jenisInvoice)) {
                            if (static::$jenisInvoice === 'claim') {
                                $query->whereClaim('y');
                            } elseif (static::$jenisInvoice === 'customer') {
                                $query->whereClaim('n');
                            }
                        }
                    }
                    $query->whereDel('0');
                },
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailOpl.toPDataOpl.toVendor',
                'toInvoiceAfterSalesArray.toWorkOrder.toDetailOpl.toKaryawan'
            ])
                ->where('buku_besar.kode_akun', '=', '110403')
                ->where('buku_besar.journal', '=', 'faktur_service');
            if (!empty(static::$jenisInvoice)) {
                if (in_array(static::$jenisInvoice, ['customer', 'claim'])) {
                    $this->query = $this->query->where('buku_besar.dk', '=', 'D')->where('buku_besar.jb', '=', '0')->where('buku_besar.no_transaksi', 'not like', 'RET-%');
                }
            } else {
                $this->query = $this->query->where('buku_besar.dk', '=', 'D')->where('buku_besar.jb', '=', '0')->where('buku_besar.no_transaksi', 'not like', 'RET-%');
            }
            if (!empty(static::$selects)) {
                $selects = implode(',', static::$selects);
                $this->query = $this->query->selectRaw($selects);
            }
            if (!empty(static::$joins)) {
                foreach (static::$joins as $key => $value) {
                    if ($value[0] === 'left') {
                        $this->query = $this->query->leftJoin($value[1], $value[2], $value[3], $value[4]);
                    } else {
                        $this->query = $this->query->join($value[0], $value[1], $value[2], $value[3]);
                    }
                }
            }
            if (!empty(static::$filters)) {
                foreach (static::$filters as $key => $value) {
                    if (is_array($value)) {
                        $this->query = $this->query->where($value[0], $value[1], $value[2]);
                    } else {
                        $this->query = $this->query->whereRaw($value);
                    }
                }
            }
            if (!empty(static::$tanggal)) {
                $this->query = $this->query->whereDate('buku_besar.tgl', '=', static::$tanggal);
            }
            if (!empty(static::$periodeTanggal)) {
                $this->query = $this->query->whereBetween('buku_besar.tgl', static::$periodeTanggal);
            }
            if (!empty(static::$perusahaan)) {
                $this->query = $this->query->where('buku_besar.id_perusahaan', '=', static::$perusahaan);
            }
            if (!empty(static::$jenisInvoice)) {
                if (static::$jenisInvoice === 'customer') {
                    $this->query = $this->query->where('buku_besar.no_transaksi', 'not like', 'INV-WO-CLM.%');
                } elseif (static::$jenisInvoice === 'claim') {
                    $this->query = $this->query->where('buku_besar.no_transaksi', 'like', 'INV-WO-CLM.%');
                }
            }
            if (!empty(static::$noInvoice)) {
                if (is_array(static::$noInvoice)) {
                    $this->query = $this->query->whereIn('buku_besar.no_transaksi', static::$noInvoice);
                } else {
                    $this->query = $this->query->where('buku_besar.no_transaksi', '=', static::$noInvoice);
                }
            }
            if (!empty(static::$orderBy)) {
                $this->query = $this->query->orderByRaw(static::$orderBy);
            }
        }
    }

    private function getResults($jenis = NULL)
    {
        if ($jenis === 'estimasi') {
            if (!empty(static::$noEstimasi)) {
                if (!is_array(static::$noEstimasi)) {
                    $value = $this->query->first();
                    if ($value !== NULL) {
                        $result = $this->generateDataEstimasi($value);
                        $this->results = json_decode($result);
                    }
                } else {
                    foreach ($this->query->get() as $key => $value) {
                        $result = $this->generateDataEstimasi($value);
                        $this->results[] = json_decode($result);
                    }
                }
            } else {
                foreach ($this->query->get() as $key => $value) {
                    $result = $this->generateDataEstimasi($value);
                    $this->results[] = json_decode($result);
                }
            }
        } elseif ($jenis === 'workOrder') {
            if (!empty(static::$noWo)) {
                if (!is_array(static::$noWo)) {
                    $value = $this->query->first();
                    if ($value !== NULL) {
                        $result = $this->generateDataWo($value);
                        $this->results = json_decode($result);
                    }
                } else {
                    foreach ($this->query->get() as $key => $value) {
                        $result = $this->generateDataWo($value);
                        $this->results[] = json_decode($result);
                    }
                }
            } else {
                foreach ($this->query->get() as $key => $value) {
                    $result = $this->generateDataWo($value);
                    $this->results[] = json_decode($result);
                }
            }
        } else {
            if (!empty(static::$noInvoice)) {
                if (!is_array(static::$noInvoice)) {
                    $value = $this->query->first();
                    if ($value !== NULL) {
                        $result = $this->generateData($value);
                        $this->results = json_decode($result);
                    }
                } else {
                    foreach ($this->query->get() as $key => $value) {
                        $result = $this->generateData($value);
                        $this->results[] = json_decode($result);
                    }
                }
            } else {
                foreach ($this->query->get() as $key => $value) {
                    $result = $this->generateData($value);
                    $this->results[] = json_decode($result);
                }
            }
        }
    }

    private function getResultsDatatable($jenis = NULL)
    {
        $this->datatable->query = $this->query;
        $results = $this->datatable->setColumns(...static::$columns)->get();
        foreach ($results['data'] as $key => $value) {
            if ($jenis === 'estimasi') {
                $result = $this->generateDataEstimasi($value);
            } elseif ($jenis === 'workOrder') {
                $result = $this->generateDataWo($value);
            } else {
                $result = $this->generateData($value);
            }
            $this->results[] = json_decode($result);
        }
        $this->resultsDatatable = [
            'draw'            => $results['draw'],
            'recordsTotal'    => $results['recordsTotal'],
            'recordsFiltered' => $results['recordsFiltered'],
            'data'            => $this->results ?? []
        ];
    }

    private function generateData($result)
    {
        $totalPendapatanOli          = 0.0;
        $totalPendapatanPartTanpaOli = 0.0;
        $totalHppPart                = 0.0;
        $totalHppOpl                 = 0.0;
        $totalPpnEFaktur             = 0.0;
        $totalPenerimaan             = 0.0;
        $totalPengeluaran            = 0.0;
        $workOrder = [];
        if ($result->toWorkOrderNoInv !== NULL) {
            $workOrder[] = $result->toWorkOrderNoInv;
        } else {
            foreach ($result->toInvoiceAfterSalesArray as $key => $value) {
                $workOrder[] = $value->toWorkOrder;
            }
        }
        $result->workOrder = $workOrder;
        foreach ($result->workOrder as $key => $value) {
            $pendapatanJasa         = 0.0;
            $pendapatanPart         = 0.0;
            $pendapatanOli          = 0.0;
            $pendapatanPartTanpaOli = 0.0;
            $pendapatanOpl          = 0.0;
            $diskonJasa             = 0.0;
            $diskonPart             = 0.0;
            $diskonOpl              = 0.0;
            $hppPart                = 0.0;
            $hppOpl                 = 0.0;
            if ($value->toCustomer !== NULL) {
                if (strlen($value->toCustomer->npwp) !== 15) {
                    $value->toCustomer->npwp = '000000000000000';
                }
                if (strpos($result->no_transaksi, 'INV-WO-CLM.') !== FALSE) {
                    $value->toCustomer->nama    = 'HONDA PROSPECT MOTOR';
                    $value->toCustomer->telepon = '0216510403';
                    $value->toCustomer->alamat  = 'Jl. Gaya Motor I Sunter II, Jakarta 14330';
                    $value->toCustomer->npwp    = '010002400092000';
                }
            }

            $totalJasaUtama    = 0;
            $totalJasaTambahan = 0;
            $totalPartUtama    = 0;
            $totalPartTambahan = 0;

            $jasaUtama    = [];
            $jasaTambahan = [];
            $partUtama    = [];
            $partTambahan = [];
            $detailJasa   = [];
            $detailPart   = [];
            $detailOpl    = [];

            if ($value->toPaket !== NULL) {
                $continue = FALSE;

                if (static::$allDetail !== TRUE) {
                    if (strpos($result->no_transaksi, 'INV-WO.') !== FALSE) {
                        if ($value->toPaket->claim !== 'n') {
                            $continue = TRUE;
                        }
                    } elseif (strpos($result->no_transaksi, 'INV-WO-CLM.') !== FALSE) {
                        if ($value->toPaket->claim !== 'y') {
                            $continue = TRUE;
                        }
                    }
                }

                if ($value->toPaket->claim === 'y') {
                    $y = $value->toPaket->claim;
                } else {
                    $n = $value->toPaket->claim;
                }

                $value->toPaket->kode     = $value->toPaket->toPaketMaster->toSvcatCode->kode;
                $value->toPaket->nama     = $value->toPaket->toPaketMaster->toSvcatCode->nama;
                $value->toPaket->harga    = $value->toPaket->total_jasa;
                $value->toPaket->diskon   = 0;
                $value->toPaket->frt      = $value->toPaket->frt;
                $value->toPaket->is_utama = 1;

                if ($continue === FALSE) {
                    if (static::$nilaiReal === TRUE) {
                        $value->toPaket->total  = $value->toPaket->claim === 'y' ? 0.0 : $value->toPaket->harga;
                        $value->toPaket->ppn    = $value->toPaket->claim === 'y' ? 0.0 : round($value->toPaket->total * 0.1);
                        $pendapatanJasa        += $value->toPaket->claim === 'y' ? 0.0 : $value->toPaket->harga;
                        $diskonJasa            += $value->toPaket->claim === 'y' ? 0.0 : $value->toPaket->diskon;
                    } else {
                        $value->toPaket->total  = $value->toPaket->harga;
                        $value->toPaket->ppn    = round($value->toPaket->total * 0.1);
                        $pendapatanJasa        += $value->toPaket->harga;
                        $diskonJasa            += $value->toPaket->diskon;
                    }

                    $totalPpnEFaktur += $value->toPaket->ppn;

                    $detailJasa[] = $value->toPaket;

                    $totalJasaUtama += $value->toPaket->total;
                    $jasaUtama[] = $value->toPaket;
                }
            }
            foreach ($value->toDetailJasa as $key1 => $value1) {
                if (static::$allDetail !== TRUE) {
                    if (strpos($result->no_transaksi, 'INV-WO.') !== FALSE) {
                        if ($value1->claim !== 'n') {
                            continue;
                        }
                    } elseif (strpos($result->no_transaksi, 'INV-WO-CLM.') !== FALSE) {
                        if ($value1->claim !== 'y') {
                            continue;
                        }
                    }
                }

                if ($value1->claim === 'y') {
                    $y = $value1->claim;
                } else {
                    $n = $value1->claim;
                }

                $value1->kode   = $value1->toJasa->toPNamaJasa->is_hpm === 1 ? $value1->toJasa->toPNamaJasa->kode : '-';
                $value1->nama   = $value1->is_utama === 1 ? 'Paket - ' . $value1->toJasa->toPNamaJasa->nama_jasa : $value1->toJasa->toPNamaJasa->nama_jasa;
                $value1->harga  = $value1->harga_jual;
                $value1->diskon = $value1->diskon_rp;
                $value1->frt    = $value1->durasi;

                if (static::$nilaiReal === TRUE) {
                    $value1->total   = $value1->claim === 'y' ? 0.0 : $value1->harga - $value1->diskon;
                    $value1->ppn     = $value1->claim === 'y' ? 0.0 : round($value1->total * 0.1);
                    $pendapatanJasa += $value1->claim === 'y' ? 0.0 : $value1->harga;
                    $diskonJasa     += $value1->claim === 'y' ? 0.0 : $value1->diskon;
                } else {
                    $value1->total   = $value1->harga - $value1->diskon;
                    $value1->ppn     = round($value1->total * 0.1);
                    $pendapatanJasa += $value1->harga;
                    $diskonJasa     += $value1->diskon;
                }

                $totalPpnEFaktur += $value1->ppn;

                $detailJasa[] = $value1;

                if ($value1->is_utama === 1) {
                    $totalJasaUtama += $value1->total;
                    $jasaUtama[] = $value1;
                } else {
                    $totalJasaTambahan += $value1->total;
                    $jasaTambahan[] = $value1;
                }
            }
            foreach ($value->toDetailPart as $key1 => $value1) {
                if (static::$allDetail !== TRUE) {
                    if (strpos($result->no_transaksi, 'INV-WO.') !== FALSE) {
                        if ($value1->claim !== 'n') {
                            continue;
                        }
                    } elseif (strpos($result->no_transaksi, 'INV-WO-CLM.') !== FALSE) {
                        if ($value1->claim !== 'y') {
                            continue;
                        }
                    }
                }

                $value1->kode     = $value1->toItem->part_number;
                $value1->nama     = $value1->toItem->nama_item;
                $value1->harga    = $value1->harga_jual;
                $value1->diskon   = $value1->diskon_rp;
                $value1->qty      = $value1->qty;
                $value1->subtotal = $value1->harga * $value1->qty;
                $value1->hpp      = $value1->harga - ($value1->harga * (($value1->toItem->toPClassItem[0]->discount ?? 0) / 100));
                $value1->hpptotal = $value1->hpp * $value1->qty;

                if (static::$nilaiReal === TRUE) {
                    $value1->total = $value1->claim === 'y' ? 0.0 : $value1->subtotal - $value1->diskon;
                    $value1->ppn   = $value1->claim === 'y' ? 0.0 : round($value1->total * 0.1);
                    if (strpos($value1->nama, 'OIL') !== FALSE && $value1->toItem->jenis_item !== "part") {
                        $value1->totalOli = $value1->total;
                    } else {
                        $value1->totalOli = 0;
                    }
                    $pendapatanPart              += $value1->claim === 'y' ? 0.0 : $value1->subtotal;
                    $pendapatanOli               += $value1->claim === 'y' ? 0.0 : $value1->totalOli;
                    $pendapatanPartTanpaOli      += $value1->claim === 'y' ? 0.0 : $value1->total - $value1->totalOli;
                    $diskonPart                  += $value1->claim === 'y' ? 0.0 : $value1->diskon;
                    $totalPendapatanOli          += $value1->claim === 'y' ? 0.0 : $value1->totalOli;
                    $totalPendapatanPartTanpaOli += $value1->claim === 'y' ? 0.0 : $value1->total - $value1->totalOli;
                } else {
                    $value1->total = $value1->subtotal - $value1->diskon;
                    $value1->ppn   = round($value1->total * 0.1);
                    if (strpos($value1->nama, 'OIL') !== FALSE && $value1->toItem->jenis_item !== "part") {
                        $value1->totalOli = $value1->total;
                    } else {
                        $value1->totalOli = 0;
                    }
                    $pendapatanPart              += $value1->subtotal;
                    $pendapatanOli               += $value1->totalOli;
                    $pendapatanPartTanpaOli      += $value1->total - $value1->totalOli;
                    $diskonPart                  += $value1->diskon;
                    $totalPendapatanOli          += $value1->totalOli;
                    $totalPendapatanPartTanpaOli += $value1->total - $value1->totalOli;
                }

                $hppPart         += $value1->hpptotal;
                $totalHppPart    += $value1->hpptotal;
                $totalPpnEFaktur += $value1->ppn;

                $detailPart[] = $value1;

                if ($value1->is_utama === 1) {
                    $totalPartUtama += $value1->total;
                    $partUtama[] = $value1;
                } else {
                    $totalPartTambahan += $value1->total;
                    $partTambahan[] = $value1;
                }
            }
            foreach ($value->toDetailOpl as $key1 => $value1) {
                if (static::$allDetail !== TRUE) {
                    if (strpos($result->no_transaksi, 'INV-WO.') !== FALSE) {
                        if ($value1->claim !== 'n') {
                            continue;
                        }
                    } elseif (strpos($result->no_transaksi, 'INV-WO-CLM.') !== FALSE) {
                        if ($value1->claim !== 'y') {
                            continue;
                        }
                    }
                }

                $value1->kode     = '-';
                $value1->nama     = $value1->toPDataOpl->nama_opl ?? $value1->keterangan;
                $value1->harga    = $value1->harga_satuan;
                $value1->diskon   = $value1->diskon_rp;
                $value1->qty      = $value1->qty;
                $value1->subtotal = $value1->harga * $value1->qty;
                // $value1->hpp      = $value1->toPDataOpl->hpp ?? $value1->hpp;
                $value1->hpptotal = $value1->hpp * $value1->qty;

                if (static::$nilaiReal === TRUE) {
                    $value1->total  = $value1->claim === 'y' ? 0.0 : $value1->subtotal - $value1->diskon;
                    $value1->ppn    = $value1->claim === 'y' ? 0.0 : round($value1->total * 0.1);
                    $pendapatanOpl += $value1->claim === 'y' ? 0.0 : $value1->subtotal;
                    $diskonOpl     += $value1->claim === 'y' ? 0.0 : $value1->diskon;
                } else {
                    $value1->total  = $value1->subtotal - $value1->diskon;
                    $value1->ppn    = round($value1->total * 0.1);
                    $pendapatanOpl += $value1->subtotal;
                    $diskonOpl     += $value1->diskon;
                }

                $hppOpl          += $value1->hpptotal;
                $totalHppOpl     += $value1->hpptotal;
                $totalPpnEFaktur += $value1->ppn;

                $detailOpl[] = $value1;

                $totalJasaTambahan += $value1->total;
                $jasaTambahan[] = $value1;
            };

            if (empty($y)) {
                $value->jenisPekerjaan = "Repair";
            } elseif (empty($n)) {
                $value->jenisPekerjaan = "Periodical Maintenance";
            } else {
                $value->jenisPekerjaan = "Periodical Maintenance & Repair";
            }
            $value->jasaUtama    = $jasaUtama;
            $value->jasaTambahan = $jasaTambahan;
            $value->partUtama    = $partUtama;
            $value->partTambahan = $partTambahan;
            $value->toDetailJasa = $detailJasa;
            $value->toDetailPart = $detailPart;
            $value->toDetailOpl  = $detailOpl;

            $dpptotal    = $pendapatanJasa + $pendapatanPart + $pendapatanOpl;
            $totalDiskon = $diskonJasa + $diskonPart + $diskonOpl;
            $subtotal    = $dpptotal - $totalDiskon;
            $totalPpn    = round($subtotal * 0.1);
            $total       = round($subtotal + $totalPpn);
            $value->nilai = (object) [
                'pendapatanJasa'         => $pendapatanJasa,
                'pendapatanPart'         => $pendapatanPart,
                'pendapatanOli'          => $pendapatanOli,          //setelah diskon
                'pendapatanPartTanpaOli' => $pendapatanPartTanpaOli, //setelah diskon
                'pendapatanOpl'          => $pendapatanOpl,
                'diskonJasa'             => $diskonJasa,
                'diskonPart'             => $diskonPart,
                'diskonOpl'              => $diskonOpl,
                'hppPart'                => $hppPart,
                'hppOpl'                 => $hppOpl,
                'dpptotal'               => $dpptotal,
                'totalDiskon'            => $totalDiskon,
                'subtotal'               => $subtotal,
                'totalPpn'               => $totalPpn,
                'totalPpnEFaktur'        => $totalPpnEFaktur,
                'total'                  => $total,

                'jasaUtama'    => $totalJasaUtama,
                'jasaTambahan' => $totalJasaTambahan,
                'partUtama'    => $totalPartUtama,
                'partTambahan' => $totalPartTambahan,
            ];
        }

        foreach ($result->toPenerimaanBengkelNoRef as $key => $value) {
            $totalPenerimaan += $value->toBukuBesar[0]->jumlah ?? 0;
        }
        foreach ($result->toPengeluaranBengkelNoRef as $key => $value) {
            $totalPengeluaran += $value->toBukuBesar[0]->jumlah ?? 0;
        }
        foreach ($result->toBukuBesar as $key => $value) {
            if ($value->kode_akun === '420101') {
                $pendapatanJasa = $value->jumlah;
            }
            if ($value->kode_akun === '420201') {
                $pendapatanPart = $value->jumlah;
            }
            if ($value->kode_akun === '420102') {
                $pendapatanOpl = $value->jumlah;
            }
            if ($value->kode_akun === '450501') {
                $diskonJasa = $value->jumlah;
            }
            if ($value->kode_akun === '450502') {
                $diskonPart = $value->jumlah;
            }
            if ($value->kode_akun === '450504') {
                $diskonOpl = $value->jumlah;
            }
            if ($value->kode_akun === '210406') {
                $totalPpn = round($value->jumlah);
            }
            if ($value->kode_akun === '110403') {
                $total = round($value->jumlah);
            }
        }
        $dpptotal     = $pendapatanJasa + $pendapatanPart + $pendapatanOpl;
        $totalDiskon  = $diskonJasa + $diskonPart + $diskonOpl;
        $subtotal     = $dpptotal - $totalDiskon;
        $totalPiutang = $total - ($totalPenerimaan - $totalPengeluaran);
        $result->nilai = (object) [
            'pendapatanJasa'         => $pendapatanJasa,
            'pendapatanPart'         => $pendapatanPart,
            'pendapatanOli'          => $totalPendapatanOli,            //setelah diskon
            'pendapatanPartTanpaOli' => $totalPendapatanPartTanpaOli,   //setelah diskon
            'pendapatanOpl'          => $pendapatanOpl,
            'diskonJasa'             => $diskonJasa,
            'diskonPart'             => $diskonPart,
            'diskonOpl'              => $diskonOpl,
            'hppPart'                => $totalHppPart,
            'hppOpl'                 => $totalHppOpl,
            'dpptotal'               => $dpptotal,
            'totalDiskon'            => $totalDiskon,
            'subtotal'               => $subtotal,
            'totalPpn'               => $totalPpn,
            'totalPpnEFaktur'        => $totalPpnEFaktur,
            'total'                  => $total,
            'totalPenerimaan'        => $totalPenerimaan,
            'totalPengeluaran'       => $totalPengeluaran,
            'totalPiutang'           => $totalPiutang,
        ];
        return json_encode($result);
    }

    private function generateDataWo($result)
    {
        $pendapatanJasa         = 0.0;
        $pendapatanPart         = 0.0;
        $pendapatanOli          = 0.0;
        $pendapatanPartTanpaOli = 0.0;
        $pendapatanOpl          = 0.0;
        $diskonJasa             = 0.0;
        $diskonPart             = 0.0;
        $diskonOpl              = 0.0;
        $hppPart                = 0.0;
        $hppOpl                 = 0.0;
        $totalDpEstimasi        = 0.0;
        $totalDpWo              = 0.0;

        $totalPpnEFaktur  = 0.0;
        $totalPenerimaan  = 0.0;
        $totalPengeluaran = 0.0;

        foreach ($result->toEstimasi->toPenerimaanBengkelNoRef as $key => $value) {
            $totalDpEstimasi += $value->toBukuBesar[0]->jumlah ?? 0;
        }

        foreach ($result->toPenerimaanBengkelNoRef as $key => $value) {
            $totalDpWo += $value->toBukuBesar[0]->jumlah ?? 0;
        }

        if ($result->toCustomer !== NULL) {
            if (strlen($result->toCustomer->npwp) !== 15) {
                $result->toCustomer->npwp = '000000000000000';
            }
        }

        $totalJasaUtama    = 0;
        $totalJasaTambahan = 0;
        $totalPartUtama    = 0;
        $totalPartTambahan = 0;

        $jasaUtama    = [];
        $jasaTambahan = [];
        $partUtama    = [];
        $partTambahan = [];
        $detailJasa   = [];
        $detailPart   = [];
        $detailOpl    = [];

        if ($result->toPaket !== NULL) {
            if ($result->toPaket->claim === 'y') {
                $y = $result->toPaket->claim;
            } else {
                $n = $result->toPaket->claim;
            }
            $result->toPaket->kode     = $result->toPaket->toPaketMaster->toSvcatCode->kode;
            $result->toPaket->nama     = $result->toPaket->toPaketMaster->toSvcatCode->nama;
            $result->toPaket->harga    = $result->toPaket->total_jasa;
            $result->toPaket->diskon   = 0;
            $result->toPaket->frt      = $result->toPaket->frt;
            $result->toPaket->is_utama = 1;

            if (static::$nilaiReal === TRUE) {
                $result->toPaket->total  = $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->harga;
                $result->toPaket->ppn    = $result->toPaket->claim === 'y' ? 0.0 : round($result->toPaket->total * 0.1);
                $pendapatanJasa         += $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->harga;
                $diskonJasa             += $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->diskon;
            } else {
                $result->toPaket->total  = $result->toPaket->harga;
                $result->toPaket->ppn    = round($result->toPaket->total * 0.1);
                $pendapatanJasa         += $result->toPaket->harga;
                $diskonJasa             += $result->toPaket->diskon;
            }

            $totalPpnEFaktur += $result->toPaket->ppn;

            $detailJasa[] = $result->toPaket;

            $totalJasaUtama += $result->toPaket->total;
            $jasaUtama[] = $result->toPaket;
        }
        foreach ($result->toDetailJasa as $key1 => $value) {
            if ($value->claim === 'y') {
                $y = $value->claim;
            } else {
                $n = $value->claim;
            }
            $value->kode   = $value->toJasa->toPNamaJasa->is_hpm === 1 ? $value->toJasa->toPNamaJasa->kode : '-';
            $value->nama   = $value->is_utama === 1 ? 'Paket - ' . $value->toJasa->toPNamaJasa->nama_jasa :  $value->toJasa->toPNamaJasa->nama_jasa;
            $value->harga  = $value->harga_jual;
            $value->diskon = $value->diskon_rp;
            $value->frt    = $value->durasi;

            if (static::$nilaiReal === TRUE) {
                $value->total    = $value->claim === 'y' ? 0.0 : $value->harga - $value->diskon;
                $value->ppn      = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
                $pendapatanJasa += $value->claim === 'y' ? 0.0 : $value->harga;
                $diskonJasa     += $value->claim === 'y' ? 0.0 : $value->diskon;
            } else {
                $value->total    = $value->harga - $value->diskon;
                $value->ppn      = round($value->total * 0.1);
                $pendapatanJasa += $value->harga;
                $diskonJasa     += $value->diskon;
            }

            $totalPpnEFaktur += $value->ppn;

            $detailJasa[] = $value;

            if ($value->is_utama === 1) {
                $totalJasaUtama += $value->total;
                $jasaUtama[] = $value;
            } else {
                $totalJasaTambahan += $value->total;
                $jasaTambahan[] = $value;
            }
        }
        foreach ($result->toDetailPart as $key1 => $value) {
            $value->kode     = $value->toItem->part_number;
            $value->nama     = $value->toItem->nama_item;
            $value->harga    = $value->harga_jual;
            $value->diskon   = $value->diskon_rp;
            $value->qty      = $value->qty;
            $value->subtotal = $value->harga * $value->qty;
            $value->hpp      = $value->harga - ($value->harga * (($value->toItem->toPClassItem[0]->discount ?? 0) / 100));
            $value->hpptotal = $value->hpp * $value->qty;

            if (static::$nilaiReal === TRUE) {
                $value->total = $value->claim === 'y' ? 0.0 : $value->subtotal - $value->diskon;
                $value->ppn   = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
                if (strpos($value->nama, 'OIL') !== FALSE && $value->toItem->jenis_item !== "part") {
                    $value->totalOli = $value->total;
                } else {
                    $value->totalOli = 0;
                }
                $pendapatanPart         += $value->claim === 'y' ? 0.0 : $value->subtotal;
                $pendapatanOli          += $value->claim === 'y' ? 0.0 : $value->totalOli;
                $pendapatanPartTanpaOli += $value->claim === 'y' ? 0.0 : $value->total - $value->totalOli;
                $diskonPart             += $value->claim === 'y' ? 0.0 : $value->diskon;
            } else {
                $value->total = $value->subtotal - $value->diskon;
                $value->ppn   = round($value->total * 0.1);
                if (strpos($value->nama, 'OIL') !== FALSE && $value->toItem->jenis_item !== "part") {
                    $value->totalOli = $value->total;
                } else {
                    $value->totalOli = 0;
                }
                $pendapatanPart         += $value->subtotal;
                $pendapatanOli          += $value->totalOli;
                $pendapatanPartTanpaOli += $value->total - $value->totalOli;
                $diskonPart             += $value->diskon;
            }

            $hppPart         += $value->hpptotal;
            $totalPpnEFaktur += $value->ppn;

            $detailPart[] = $value;

            if ($value->is_utama === 1) {
                $totalPartUtama += $value->total;
                $partUtama[] = $value;
            } else {
                $totalPartTambahan += $value->total;
                $partTambahan[] = $value;
            }
        }
        foreach ($result->toDetailOpl as $key1 => $value) {
            $value->kode     = '-';
            $value->nama     = $value->toPDataOpl->nama_opl ?? $value->keterangan;
            $value->harga    = $value->harga_satuan;
            $value->diskon   = $value->diskon_rp;
            $value->qty      = $value->qty;
            $value->subtotal = $value->harga * $value->qty;
            // $value->hpp      = $value->toPDataOpl->hpp ?? $value->hpp;
            $value->hpptotal = $value->hpp * $value->qty;

            if (static::$nilaiReal === TRUE) {
                $value->total   = $value->claim === 'y' ? 0.0 : $value->subtotal - $value->diskon;
                $value->ppn     = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
                $pendapatanOpl += $value->claim === 'y' ? 0.0 : $value->subtotal;
                $diskonOpl     += $value->claim === 'y' ? 0.0 : $value->diskon;
            } else {
                $value->total   = $value->subtotal - $value->diskon;
                $value->ppn     = round($value->total * 0.1);
                $pendapatanOpl += $value->subtotal;
                $diskonOpl     += $value->diskon;
            }

            $hppOpl          += $value->hpptotal;
            $totalPpnEFaktur += $value->ppn;

            $detailOpl[] = $value;

            $totalJasaTambahan += $value->total;
            $jasaTambahan[] = $value;
        }

        if (empty($y)) {
            $result->jenisPekerjaan = "Repair";
        } elseif (empty($n)) {
            $result->jenisPekerjaan = "Periodical Maintenance";
        } else {
            $result->jenisPekerjaan = "Periodical Maintenance & Repair";
        }
        $result->jasaUtama    = $jasaUtama;
        $result->jasaTambahan = $jasaTambahan;
        $result->partUtama    = $partUtama;
        $result->partTambahan = $partTambahan;
        $result->toDetailJasa = $detailJasa;
        $result->toDetailPart = $detailPart;
        $result->toDetailOpl  = $detailOpl;

        $dpptotal    = $pendapatanJasa + $pendapatanPart + $pendapatanOpl;
        $totalDiskon = $diskonJasa + $diskonPart + $diskonOpl;
        $subtotal    = $dpptotal - $totalDiskon;
        $totalPpn    = round($subtotal * 0.1);
        $total       = round($subtotal + $totalPpn);
        $result->nilaiWo = (object) [
            'pendapatanJasa'         => $pendapatanJasa,
            'pendapatanPart'         => $pendapatanPart,
            'pendapatanOli'          => $pendapatanOli,                  //setelah diskon
            'pendapatanPartTanpaOli' => $pendapatanPartTanpaOli,         //setelah diskon
            'pendapatanOpl'          => $pendapatanOpl,
            'diskonJasa'             => $diskonJasa,
            'diskonPart'             => $diskonPart,
            'diskonOpl'              => $diskonOpl,
            'hppPart'                => $hppPart,
            'hppOpl'                 => $hppOpl,
            'dpptotal'               => $dpptotal,
            'totalDiskon'            => $totalDiskon,
            'subtotal'               => $subtotal,
            'totalPpn'               => $totalPpn,
            'total'                  => $total,
            'totalDpEstimasi'        => $totalDpEstimasi,
            'totalDpWo'              => $totalDpWo,
            'totalDp'                => $totalDpEstimasi + $totalDpWo,

            'jasaUtama'    => $totalJasaUtama,
            'jasaTambahan' => $totalJasaTambahan,
            'partUtama'    => $totalPartUtama,
            'partTambahan' => $totalPartTambahan,
        ];

        $bukuBesar = [];
        if (count($result->toBukuBesarByWo) > 0) {
            $bukuBesar = $result->toBukuBesarByWo;
        } else {
            if ($result->toInvoiceAfterSales !== NULL) {
                $bukuBesar = $result->toInvoiceAfterSales->toBukuBesar;
            }
        }
        $result->bukuBesar = $bukuBesar;
        if (count($result->bukuBesar) > 0) {
            foreach ($result->bukuBesar[0]->toPenerimaanBengkelNoRef as $key => $value) {
                $totalPenerimaan += $value->toBukuBesar[0]->jumlah ?? 0;
            }
            foreach ($result->bukuBesar[0]->toPengeluaranBengkelNoRef as $key => $value) {
                $totalPengeluaran += $value->toBukuBesar[0]->jumlah ?? 0;
            }
            foreach ($result->bukuBesar as $key => $value) {
                if ($value->kode_akun === '420101') {
                    $pendapatanJasa = $value->jumlah;
                }
                if ($value->kode_akun === '420201') {
                    $pendapatanPart = $value->jumlah;
                }
                if ($value->kode_akun === '420102') {
                    $pendapatanOpl = $value->jumlah;
                }
                if ($value->kode_akun === '450501') {
                    $diskonJasa = $value->jumlah;
                }
                if ($value->kode_akun === '450502') {
                    $diskonPart = $value->jumlah;
                }
                if ($value->kode_akun === '450504') {
                    $diskonOpl = $value->jumlah;
                }
                if ($value->kode_akun === '210406') {
                    $totalPpn = round($value->jumlah);
                }
                if ($value->kode_akun === '110403') {
                    $total = round($value->jumlah);
                }
            }
            $dpptotal     = $pendapatanJasa + $pendapatanPart + $pendapatanOpl;
            $totalDiskon  = $diskonJasa + $diskonPart + $diskonOpl;
            $subtotal     = $dpptotal - $totalDiskon;
            $totalPiutang = $total - ($totalPenerimaan - $totalPengeluaran);
            $result->nilaiBukuBesar = (object) [
                'pendapatanJasa'   => $pendapatanJasa,
                'pendapatanPart'   => $pendapatanPart,
                'pendapatanOpl'    => $pendapatanOpl,
                'diskonJasa'       => $diskonJasa,
                'diskonPart'       => $diskonPart,
                'diskonOpl'        => $diskonOpl,
                'dpptotal'         => $dpptotal,
                'totalDiskon'      => $totalDiskon,
                'subtotal'         => $subtotal,
                'totalPpn'         => $totalPpn,
                'totalPpnEFaktur'  => $totalPpnEFaktur,
                'total'            => $total,
                'totalPenerimaan'  => $totalPenerimaan,
                'totalPengeluaran' => $totalPengeluaran,
                'totalPiutang'     => $totalPiutang,
            ];
        }
        return json_encode($result);
    }

    private function generateDataEstimasi($result)
    {
        $pendapatanJasa         = 0.0;
        $pendapatanPart         = 0.0;
        $pendapatanOli          = 0.0;
        $pendapatanPartTanpaOli = 0.0;
        $pendapatanOpl          = 0.0;
        $diskonJasa             = 0.0;
        $diskonPart             = 0.0;
        $diskonOpl              = 0.0;
        $hppPart                = 0.0;
        $hppOpl                 = 0.0;
        $totalDp                = 0.0;

        foreach ($result->toPenerimaanBengkelNoRef as $key => $value) {
            $totalDp += $value->toBukuBesar[0]->jumlah ?? 0;
        }

        if ($result->toCustomer !== NULL) {
            if (strlen($result->toCustomer->npwp) !== 15) {
                $result->toCustomer->npwp = '000000000000000';
            }
        }

        $totalJasaUtama    = 0;
        $totalJasaTambahan = 0;
        $totalPartUtama    = 0;
        $totalPartTambahan = 0;

        $jasaUtama    = [];
        $jasaTambahan = [];
        $partUtama    = [];
        $partTambahan = [];
        $detailJasa   = [];
        $detailPart   = [];
        $detailOpl    = [];

        if ($result->toPaket !== NULL) {
            if ($result->toPaket->claim === 'y') {
                $y = $result->toPaket->claim;
            } else {
                $n = $result->toPaket->claim;
            }
            $result->toPaket->kode     = $result->toPaket->toPaketMaster->toSvcatCode->kode;
            $result->toPaket->nama     = $result->toPaket->toPaketMaster->toSvcatCode->nama;
            $result->toPaket->harga    = $result->toPaket->total_jasa;
            $result->toPaket->diskon   = 0;
            $result->toPaket->frt      = $result->toPaket->frt;
            $result->toPaket->is_utama = 1;

            $result->toPaket->total  = $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->harga;
            $result->toPaket->ppn    = $result->toPaket->claim === 'y' ? 0.0 : round($result->toPaket->total * 0.1);
            $pendapatanJasa         += $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->harga;
            $diskonJasa             += $result->toPaket->claim === 'y' ? 0.0 : $result->toPaket->diskon;

            $detailJasa[] = $result->toPaket;

            $totalJasaUtama += $result->toPaket->total;
            $jasaUtama[] = $result->toPaket;
        }
        foreach ($result->toDetailJasa as $key1 => $value) {
            if ($value->claim === 'y') {
                $y = $value->claim;
            } else {
                $n = $value->claim;
            }
            $value->kode   = $value->toJasa->toPNamaJasa->is_hpm === 1 ? $value->toJasa->toPNamaJasa->kode : '-';
            $value->nama   = $value->is_utama === 1 ? 'Paket - ' . $value->toJasa->toPNamaJasa->nama_jasa :  $value->toJasa->toPNamaJasa->nama_jasa;
            $value->harga  = $value->harga_jual;
            $value->diskon = $value->diskon_rp;
            $value->frt    = $value->durasi;

            $value->total    = $value->claim === 'y' ? 0.0 : $value->harga - $value->diskon;
            $value->ppn      = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
            $pendapatanJasa += $value->claim === 'y' ? 0.0 : $value->harga;
            $diskonJasa     += $value->claim === 'y' ? 0.0 : $value->diskon;

            $detailJasa[] = $value;

            if ($value->is_utama === 1) {
                $totalJasaUtama += $value->total;
                $jasaUtama[] = $value;
            } else {
                $totalJasaTambahan += $value->total;
                $jasaTambahan[] = $value;
            }
        }
        foreach ($result->toDetailPart as $key1 => $value) {
            $value->kode     = $value->toItem->part_number;
            $value->nama     = $value->toItem->nama_item;
            $value->harga    = $value->harga_jual;
            $value->diskon   = $value->diskon_rp;
            $value->qty      = $value->qty;
            $value->subtotal = $value->harga * $value->qty;
            $value->hpp      = $value->harga - ($value->harga * (($value->toItem->toPClassItem[0]->discount ?? 0) / 100));
            $value->hpptotal = $value->hpp * $value->qty;

            $value->total = $value->claim === 'y' ? 0.0 : $value->subtotal - $value->diskon;
            $value->ppn   = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
            if (strpos($value->nama, 'OIL') !== FALSE && $value->toItem->jenis_item !== "part") {
                $value->totalOli = $value->total;
            } else {
                $value->totalOli = 0;
            }
            $pendapatanPart         += $value->claim === 'y' ? 0.0 : $value->subtotal;
            $pendapatanOli          += $value->claim === 'y' ? 0.0 : $value->totalOli;
            $pendapatanPartTanpaOli += $value->claim === 'y' ? 0.0 : $value->total - $value->totalOli;
            $diskonPart             += $value->claim === 'y' ? 0.0 : $value->diskon;

            $hppPart         += $value->hpptotal;

            $detailPart[] = $value;

            if ($value->is_utama === 1) {
                $totalPartUtama += $value->total;
                $partUtama[] = $value;
            } else {
                $totalPartTambahan += $value->total;
                $partTambahan[] = $value;
            }
        }
        foreach ($result->toDetailOpl as $key1 => $value) {
            $value->kode     = '-';
            $value->nama     = $value->toPDataOpl->nama_opl ?? $value->keterangan;
            $value->harga    = $value->harga_satuan;
            $value->diskon   = $value->diskon_rp;
            $value->qty      = $value->qty;
            $value->subtotal = $value->harga * $value->qty;
            // $value->hpp      = $value->toPDataOpl->hpp ?? $value->hpp;
            $value->hpptotal = $value->hpp * $value->qty;

            $value->total   = $value->claim === 'y' ? 0.0 : $value->subtotal - $value->diskon;
            $value->ppn     = $value->claim === 'y' ? 0.0 : round($value->total * 0.1);
            $pendapatanOpl += $value->claim === 'y' ? 0.0 : $value->subtotal;
            $diskonOpl     += $value->claim === 'y' ? 0.0 : $value->diskon;

            $hppOpl          += $value->hpptotal;

            $detailOpl[] = $value;

            $totalJasaTambahan += $value->total;
            $jasaTambahan[] = $value;
        }

        if (empty($y)) {
            $result->jenisPekerjaan = "Repair";
        } elseif (empty($n)) {
            $result->jenisPekerjaan = "Periodical Maintenance";
        } else {
            $result->jenisPekerjaan = "Periodical Maintenance & Repair";
        }
        $result->jasaUtama    = $jasaUtama;
        $result->jasaTambahan = $jasaTambahan;
        $result->partUtama    = $partUtama;
        $result->partTambahan = $partTambahan;
        $result->toDetailJasa = $detailJasa;
        $result->toDetailPart = $detailPart;
        $result->toDetailOpl  = $detailOpl;

        $dpptotal    = $pendapatanJasa + $pendapatanPart + $pendapatanOpl;
        $totalDiskon = $diskonJasa + $diskonPart + $diskonOpl;
        $subtotal    = $dpptotal - $totalDiskon;
        $totalPpn    = round($subtotal * 0.1);
        $total       = round($subtotal + $totalPpn);
        $result->nilai = (object) [
            'pendapatanJasa'         => $pendapatanJasa,
            'pendapatanPart'         => $pendapatanPart,
            'pendapatanOli'          => $pendapatanOli,            //setelah diskon
            'pendapatanPartTanpaOli' => $pendapatanPartTanpaOli,   //setelah diskon
            'pendapatanOpl'          => $pendapatanOpl,
            'diskonJasa'             => $diskonJasa,
            'diskonPart'             => $diskonPart,
            'diskonOpl'              => $diskonOpl,
            'hppPart'                => $hppPart,
            'hppOpl'                 => $hppOpl,
            'dpptotal'               => $dpptotal,
            'totalDiskon'            => $totalDiskon,
            'subtotal'               => $subtotal,
            'totalPpn'               => $totalPpn,
            'total'                  => $total,
            'totalDp'                => $totalDp,

            'jasaUtama'    => $totalJasaUtama,
            'jasaTambahan' => $totalJasaTambahan,
            'partUtama'    => $totalPartUtama,
            'partTambahan' => $totalPartTambahan,
        ];

        return json_encode($result);
    }
}
