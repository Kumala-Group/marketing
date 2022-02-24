<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mPType extends Model
{
    protected $table = 'db_hino.p_type';
    protected $primaryKey = 'id_type';
    protected $keyType = 'string';
}
