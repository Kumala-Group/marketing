<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mLevelMekanik extends Model
{
    protected $table = 'db_honda_as.level_mekanik';
    protected $primaryKey = 'nik';
    protected $keyType = 'string';
}
