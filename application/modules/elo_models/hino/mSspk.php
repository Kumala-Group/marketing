<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mSspk extends Model
{
    protected $table = 'db_hino.s_spk';
    protected $primaryKey = 'no_spk';
    protected $keyType = 'string';

    public function toPenerimaanUnit()
    {
        return $this->hasMany(mPenerimaanUnit::class, 'no_ref', 'no_spk');
    }

    public function toHistoryPlanDoSpv()
    {
        return $this->hasMany(mHistoryPlanDoSpv::class, 'no_spk', 'no_spk');
    }

    public function toPenjualanUnit()
    {
        return $this->hasMany(mPenjualanUnit::class, 'no_spk', 'no_spk');
    }

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, 'kode_unit', 'kode_unit');
    }
}
