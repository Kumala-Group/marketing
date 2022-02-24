<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mStokItem extends Model
{
    protected $table = 'db_honda_sp.stok_item';
    protected $primaryKey = 'id_stok_item';
    protected $keyType = 'integer';
}
