<?php

namespace app\modules\elo_models\wuling;

use Illuminate\Database\Eloquent\Model;

class mMaintenanceWOInformation extends Model
{
    protected $table = 'db_wuling_as.service_reception';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    
    public function toKodeSGMw()
    {
        return $this->belongsTo(mKodeCabangSGMW::class, 'kode_cabang_sgmw', 'id_sgmw');
    }
}
