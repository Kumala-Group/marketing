<?php

namespace app\modules\elo_models\wuling;

use app\modules\elo_models\kmg\mPerusahaan;
use Illuminate\Database\Eloquent\Model;

class mKodeCabangSGMW extends Model
{
    protected $table = 'db_wuling_as.kode_cabang_sgmw';
    protected $primaryKey = 'no_invoice';
    protected $keyType = 'string';
    public $timestamps = false;
    
    public function toMaintenanceWO()
    {
        return $this->hasOne(mMaintenanceWOInformation::class, 'id_sgmw', 'kode_cabang_sgmw');
    }

    public function toMaintenancePay()
    {
        return $this->hasOne(mMaintenancePayment::class, 'kode_sgmw', 'kode_cabang_sgmw');
    }

    public function toPerusahaan()
    {
        return $this->belongsTo(mPerusahaan::class,'id_perusahaan','id_perusahaan');
    }

    public function toMaintenanceHistory()
    {
        return $this->belongsTo(mMaintenanceHistory::class,'kode_sgmw','kode_cabang_sgmw');
    }

}
