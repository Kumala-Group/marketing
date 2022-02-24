<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mEstDetailLain extends Model
{
    protected $table = 'db_honda_as.est_detail_lain';
    protected $primaryKey = 'id_detail_lain_est';
    protected $keyType = 'integer';

    public function toPDataOpl()
    {
        return $this->hasOne(mPDataOpl::class, 'id', 'id_opl');
    }
}
