<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mPRegion extends Model
{
    protected $table = 'db_hino.p_region';
    protected $primaryKey = 'id_region';
    protected $keyType = 'integer';
}
