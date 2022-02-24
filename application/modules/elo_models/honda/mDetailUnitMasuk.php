<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mDetailUnitMasuk extends Model
{
    protected $table = 'db_honda.detail_unit_masuk';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'string';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, 'kode_unit', 'kode_unit');
    }
}
