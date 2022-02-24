<?php

namespace app\modules\elo_models\kmg;

use Illuminate\Database\Eloquent\Model;

class mSp extends Model
{
    protected $table = 'sp';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = array('tanggal', 'id_karyawan', 'id_sp', 'keterangan');

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'id_karyawan', 'id_karyawan');
    }

    public function toPSp()
    {
        return $this->hasOne(mPSp::class, 'id', 'id_sp');
    }
}
