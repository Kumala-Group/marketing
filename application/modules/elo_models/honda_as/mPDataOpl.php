<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mPDataOpl extends Model
{
    protected $table = 'db_honda_as.p_data_opl';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toVendor()
    {
        return $this->belongsTo(mVendor::class, 'vendor', 'id');
    }
}
