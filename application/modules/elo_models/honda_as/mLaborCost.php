<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mLaborCost extends Model
{
    protected $table = 'db_honda_as.labor_cost';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
}
