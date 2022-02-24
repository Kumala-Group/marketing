<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\honda_sp\mPClassItem;

class mGroupPelanggan extends Model
{
    protected $table = 'db_honda_sp.group_pelanggan';
    protected $primaryKey = 'id_group_pelanggan';
    protected $keyType = 'integer';
}
