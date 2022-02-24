<?php

namespace app\modules\elo_models\mercedes_sp;

use Illuminate\Database\Eloquent\Model;

class mPGroupItem extends Model
{
    protected $table = 'db_mercedes_sp.p_group_item';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
