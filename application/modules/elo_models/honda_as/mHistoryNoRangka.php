<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mHistoryNoRangka extends Model
{
    protected $table = 'db_honda_as.history_norangka';
    protected $primaryKey = 'id_history_norangka';
    protected $keyType = 'integer';
    const CREATED_AT = 'w_insert';

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, "id_customer", "id_customer");
    }

}
