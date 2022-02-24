<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mCustomer extends Model
{
    protected $table = 'db_honda_as.customer';
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';

    public function toDetailUnit()
    {
        return $this->belongsTo(mDetailUnitCustomer::class,'id_customer','id_customer');
    }
}
