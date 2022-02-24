<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mSvcatCodeType extends Model
{
    protected $table = 'db_honda_as.svcatcode_type';
    protected $primaryKey = 'id_type';
    protected $keyType = 'integer';
}
