<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mWoDetailJasa extends Model
{
    protected $table = 'db_mercedes_as.wo_detail_jasa';
    protected $primaryKey = 'id_detail_jasa_wo';
    protected $keyType = 'integer';

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'kode_jasa', 'kode_jasa');
    }
    
    public function toHistoryProgressJasa()
    {
        return $this->hasOne(mHistoryProgressJasa::class, 'id_detail_jasa_wo', 'id_detail_jasa_wo');
    }
}
