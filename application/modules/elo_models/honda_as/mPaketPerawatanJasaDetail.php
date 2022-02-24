<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mPaketPerawatanJasaDetail extends Model
{
    protected $table = 'db_honda_as.paket_perawatan_jasa_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toMaster()
    {
        return $this->belongsTo(mPaketPerawatanMaster::class, 'paket_perawatan_id', 'id');
    }

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'id_jasa', 'jasa_id');
    }

}
