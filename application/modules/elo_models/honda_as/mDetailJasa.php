<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mDetailJasa extends Model
{
    protected $table = 'db_honda_as.detail_jasa';
    protected $primaryKey = 'id_detail_jasa';
    protected $keyType = 'integer';

    public function toJasa()
    {
        return $this->hasOne(mJasa::class, 'id_jasa', 'id_jasa');
    }
}
