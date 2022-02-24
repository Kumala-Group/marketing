<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mPType extends Model
{
    protected $table = 'db_mercedes_as.p_type';
    protected $primaryKey = 'id_type';
    protected $keyType = 'integer';
}
