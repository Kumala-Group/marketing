<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mDetailUnitCustomer extends Model
{
    protected $table = 'db_honda_as.detail_unit_customer';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, "kode_unit", "kode_unit");
    }

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, "id_customer", "id_customer");
    }

    public function toHistory()
    {
        return $this->hasMany(mHistoryNoRangka::class, "no_rangka", "no_rangka");
    }
}
