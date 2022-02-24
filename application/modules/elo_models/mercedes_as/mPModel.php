<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mPModel extends Model
{
    protected $table = 'db_mercedes_as.p_model';
    protected $primaryKey = 'id_model';
    protected $keyType = 'integer';
}
