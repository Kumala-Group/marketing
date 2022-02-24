<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mRekapInsentif extends Model
{
    protected $table = 'db_honda.rekap_poin_insentif';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
}
