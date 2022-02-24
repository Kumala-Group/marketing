<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mPWarna extends Model
{
    protected $table = 'db_honda_as.p_warna';
    protected $primaryKey = 'id_warna';
    protected $keyType = 'integer';
}
