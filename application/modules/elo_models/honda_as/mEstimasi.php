<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda\mPenerimaanBengkel;
use app\modules\elo_models\honda\mUsers;
use app\modules\elo_models\kmg\mKaryawan;
use app\modules\elo_models\kmg\mPerusahaan;
use Illuminate\Database\Eloquent\Model;

class mEstimasi extends Model
{
    protected $table = 'db_honda_as.estimasi';
    protected $primaryKey = 'no_estimasi';
    protected $keyType = 'string';
    protected $fillable = ["no_estimasi", "no_rangka", "id_customer", "id_perusahaan", "tgl_service", "km_masuk", "kode_paket_wo", "keluhan", "keterangan", "total_biaya_jasa", "total_biaya_part", "id_pesanan_penjualan", "total_biaya_lain", "diskon", "diskon_rp", "pajak", "pajak_rp", "grand_total", "c_start", "c_finish", "fuel_level", "closed", "used", "user", "w_insert", "pud", "kode_lokasi", "note", "batal_estimasi"];
    const CREATED_AT = 'w_insert';

    public function toPKategoriWo()
    {
        return $this->hasOne(mPKategoriWo::class, "kode_kategori_wo", "kode_paket_wo");
    }

    public function toLokasiService()
    {
        return $this->hasOne(mLokasiService::class, "kode_lokasi", "kode_lokasi");
    }

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, 'id_customer', 'id_customer');
    }

    public function toWorkOrder()
    {
        return $this->hasOne(mWorkOrder::class, 'no_estimasi', 'no_estimasi');
    }

    public function toDetailUnitCustomer()
    {
        return $this->hasOne(mDetailUnitCustomer::class, 'no_rangka', 'no_rangka');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'user');
    }
    public function toUser()
    {
        return $this->hasOne(mUsers::class, 'username', 'user');
    }

    public function toDetailJasa()
    {
        return $this->hasMany(mEstDetailJasa::class, 'no_estimasi', 'no_estimasi');
    }

    public function toDetailOpl()
    {
        return $this->hasMany(mEstDetailLain::class, 'no_estimasi', 'no_estimasi');
    }

    public function toDetailPart()
    {
        return $this->hasMany(mEstDetailPart::class, 'no_estimasi', 'no_estimasi');
    }

    public function toPaket()
    {
        return $this->hasOne(mEstPaket::class, 'no_estimasi', 'no_estimasi');
    }
    public function toPenerimaanBengkelNoRef()
    {
        return $this->hasMany(mPenerimaanBengkel::class, 'no_ref', 'no_estimasi');
    }
    public function toPerusahaan()
    {
        return $this->hasOne(mPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
