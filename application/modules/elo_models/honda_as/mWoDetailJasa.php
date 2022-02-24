<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mWoDetailJasa extends Model
{
    protected $table = 'db_honda_as.wo_detail_jasa';
    protected $primaryKey = 'id_detail_jasa_wo';
    protected $keyType = 'integer';

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'kode_jasa', 'kode_jasa');
    }

    public function toWorkOrder()
    {
        return $this->belongsTo(mWorkOrder::class, 'no_wo', 'no_wo');
    }

    public function toHistoryProgressJasa()
    {
        return $this->hasOne(mHistoryProgressJasa::class, "id_detail_jasa_wo", "id_detail_jasa_wo");
    }
    public function toHistoryProgressJasaArray()
    {
        return $this->hasMany(mHistoryProgressJasa::class, "id_detail_jasa_wo", "id_detail_jasa_wo");
    }
}
