<?php

namespace app\modules\elo_models\kmg;

use app\modules\elo_models\honda_as\mKodeSa;
use app\modules\elo_models\honda_as\mLevelMekanik;
use Illuminate\Database\Eloquent\Model;

class mKaryawan extends Model
{
    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';
    protected $keyType = 'integer';

    public function toBrand()
    {
        return $this->hasOne(mBrand::class, 'id_brand', 'id_brand');
    }

    public function toJabatan()
    {
        return $this->hasOne(mJabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function toPerusahaan()
    {
        return $this->hasOne(mPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }

    public function toDivisi()
    {
        return $this->hasOne(mPDivisi::class, 'id_divisi', 'id_divisi');
    }

    public function toKodeSa()
    {
        return $this->hasOne(mKodeSa::class, "nik", "nik");
    }

    public function toLevelMekanik()
    {
        return $this->hasOne(mLevelMekanik::class, "nik", "nik");
    }

    //connect back to children
    public function toSp()
    {
        return $this->belongsTo(mSp::class, 'id_karyawan', 'id_karyawan');
    }
}
