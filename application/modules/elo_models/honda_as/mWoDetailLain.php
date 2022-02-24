<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mWoDetailLain extends Model
{
    protected $table = 'db_honda_as.wo_detail_lain';
    protected $primaryKey = 'id_detail_lain_wo';
    protected $keyType = 'integer';

    public function toPDataOpl()
    {
        return $this->hasOne(mPDataOpl::class, 'id', 'id_opl');
    }

    public function toLevelMekanik()
    {
        return $this->hasOne(mLevelMekanik::class, "nik", "used");
    }


    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, "nik", "used");
    }
}
