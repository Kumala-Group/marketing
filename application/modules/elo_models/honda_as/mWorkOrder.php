<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda\mBukuBesar;
use app\modules\elo_models\honda\mPenerimaanBengkel;
use app\modules\elo_models\honda\mUsers;
use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\kmg\mKaryawan;
use app\modules\elo_models\honda_as\mEstimasi;
use app\modules\elo_models\honda_as\mWoDetailJasa;
use app\modules\elo_models\kmg\mPerusahaan;

class mWorkOrder extends Model
{
    protected $table = 'db_honda_as.work_order';
    protected $primaryKey = 'no_wo';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, 'id_customer', 'id_customer');
    }

    public function toDetailUnitCustomer()
    {
        return $this->hasOne(mDetailUnitCustomer::class, 'no_rangka', 'no_rangka');
    }

    public function toEstimasi()
    {
        return $this->hasOne(mEstimasi::class, 'no_estimasi', 'no_estimasi');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'user');
    }
    public function toUser()
    {
        return $this->hasOne(mUsers::class, 'username', 'user');
    }

    public function toInvoiceAfterSales()
    {
        return $this->hasOne(mInvoiceAfterSales::class, 'no_ref', 'no_wo');
    }

    public function toDetailJasa()
    {
        return $this->hasMany(mWoDetailJasa::class, 'no_wo', 'no_wo');
    }

    public function toDetailOpl()
    {
        return $this->hasMany(mWoDetailLain::class, 'no_wo', 'no_wo');
    }

    public function toDetailPart()
    {
        return $this->hasMany(mWoDetailPart::class, 'no_wo', 'no_wo');
    }

    public function toBukuBesarByWo()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_wo');
    }

    public function toBukuBesarByNoRef()
    {
        return $this->hasMany(mBukuBesar::class, 'no_ref', 'no_wo');
    }

    public function toPaket()
    {
        return $this->hasOne(mWoPaket::class, 'no_wo', 'no_wo');
    }

    public function toPenerimaanBengkelNoRef()
    {
        return $this->hasMany(mPenerimaanBengkel::class, 'no_ref', 'no_wo');
    }

    public function toPerusahaan()
    {
        return $this->hasOne(mPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function toHutangVendorLokal()
    {
        return $this->hasMany(mHutangVendorLokal::class, "no_ref", "no_wo");
    }
}
