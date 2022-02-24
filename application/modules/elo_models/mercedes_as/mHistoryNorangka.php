<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mHistoryNorangka extends Model
{
    protected $table = 'db_mercedes_as.history_norangka';
    protected $primaryKey = 'id_history_norangka';
    protected $keyType = 'integer';
    protected $fillable = ["no_rangka", "id_customer"];
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';
}
