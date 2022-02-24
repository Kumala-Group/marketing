<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mVehicleCode extends Model
{
    protected $table = 'db_honda_as.vehicle_code';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
}
