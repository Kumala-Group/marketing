<?php

namespace app\modules\elo_models\wuling;

use Illuminate\Database\Eloquent\Model;

class mMaintenanceHistory extends Model
{
    protected $table = 'db_wuling_as.maintenance_work_order_history_detail_information';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKodeSGMw()
    {
        return $this->belongsTo(mKodeCabangSGMW::class, 'kode_cabang_sgmw', 'id_sgmw');
    }

}
