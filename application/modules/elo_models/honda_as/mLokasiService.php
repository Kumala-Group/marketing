<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mLokasiService extends Model
{
    protected $table = 'db_honda_as.lokasi_service';
    protected $primaryKey = 'id_lokasi_service';
    protected $keyType = 'integer';
}
