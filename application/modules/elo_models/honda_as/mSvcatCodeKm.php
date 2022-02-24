<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mSvcatCodeKm extends Model
{
    protected $table = 'db_honda_as.svcatcode_km';
    protected $primaryKey = 'id_km';
    protected $keyType = 'integer';
}
