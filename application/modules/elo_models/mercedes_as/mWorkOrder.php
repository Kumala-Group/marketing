<?php

namespace app\modules\elo_models\mercedes_as;

use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mWorkOrder extends Model
{
    protected $table = 'db_mercedes_as.work_order';
    protected $primaryKey = 'no_wo';
    protected $keyType = 'string';
    protected $guarded = [];
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, 'id_customer', 'id_customer');
    }

    public function toEstimasi()
    {
        return $this->hasOne(mEstimasi::class, "no_estimasi", "no_estimasi");
    }

    public function toDetailUnitCustomer()
    {
        return $this->hasOne(mDetailUnitCustomer::class, 'no_rangka', 'no_rangka');
    }

    public function toDetailJasa()
    {
        return $this->hasMany(mWoDetailJasa::class, 'no_wo', 'no_wo');
    }

    public function toDetailPart()
    {
        return $this->hasMany(mWoDetailPart::class, 'no_wo', 'no_wo');
    }

    public function toDetailLain()
    {
        return $this->hasMany(mWoDetailLain::class, 'no_wo', 'no_wo');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'user');
    }
}
