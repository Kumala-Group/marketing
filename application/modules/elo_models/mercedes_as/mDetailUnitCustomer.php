<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mDetailUnitCustomer extends Model
{
    protected $table = 'db_mercedes_as.detail_unit_customer';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'string';
    protected $guarded = [];
    const CREATED_AT = 'w_insert';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, "kode_unit", "kode_unit");
    }
}
