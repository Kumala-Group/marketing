<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mPModel extends Model
{
    protected $table = 'db_honda_as.p_model';
    protected $primaryKey = 'id_model';
    protected $keyType = 'integer';
}
