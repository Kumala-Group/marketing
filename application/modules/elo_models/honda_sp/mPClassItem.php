<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mPClassItem extends Model
{
    protected $table = 'db_honda_sp.p_class_item';
    protected $primaryKey = 'id_class_item';
    protected $keyType = 'integer';
}
