<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mJasa extends Model
{
    protected $table = 'db_honda_as.jasa';
    protected $primaryKey = 'id_jasa';
    protected $keyType = 'integer';

    public function toPNamaJasa()
    {
        return $this->hasOne(mPNamaJasa::class, 'id_p_nama_jasa', 'id_p_nama_jasa');
    }

    public function toDetailJasa()
    {
        return $this->hasOne(mDetailJasa::class, 'id_jasa', 'id_jasa');
    }

}
