<?php

namespace app\modules\elo_models\mercedes_sp;

use Illuminate\Database\Eloquent\Model;

class mItem extends Model
{
    protected $table = 'db_mercedes_sp.item';
    protected $primaryKey = 'id_item';
    protected $keyType = 'integer';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
