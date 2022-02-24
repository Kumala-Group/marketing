<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mPustakaVarian extends Model
{
    protected $table = 'db_honda.p_varian';
    protected $primaryKey = 'id_varian';
    protected $keyType = 'integer';
}
