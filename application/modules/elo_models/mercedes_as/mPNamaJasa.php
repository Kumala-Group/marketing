<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\mercedes_as\mJasa;

class mPNamaJasa extends Model
{
    protected $table = 'db_mercedes_as.p_nama_jasa';
    protected $primaryKey = 'id_p_nama_jasa';
    protected $keyType = 'integer';

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'id_p_nama_jasa', 'id_p_nama_jasa');
    }
}
