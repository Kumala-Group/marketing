<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\honda_as\mPDataOpl;

class mWoDetailLain extends Model
{
    protected $table = 'db_mercedes_as.wo_detail_lain';
    protected $primaryKey = 'id_detail_lain_wo';
    protected $keyType = 'integer';

    public function toPDataOpl()
    {
        return $this->hasOne(mPDataOpl::class, 'id', 'id_opl');
    }
}
