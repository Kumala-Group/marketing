<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mEstDetailJasa extends Model
{
    protected $table = 'db_honda_as.est_detail_jasa';
    protected $primaryKey = 'id_detail_jasa_est';
    protected $keyType = 'integer';

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'kode_jasa', 'kode_jasa');
    }
}
