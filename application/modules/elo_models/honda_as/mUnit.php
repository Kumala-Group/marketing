<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mUnit extends Model
{
    protected $table = 'db_honda_as.unit';
    protected $primaryKey = 'id_unit';
    protected $keyType = 'integer';

    public function toPModel()
    {
        return $this->hasOne(mPModel::class, 'id_model', 'id_model');
    }

    public function toPTipe()
    {
        return $this->hasOne(mPTipe::class, 'id_type', 'id_type');
    }

    public function toVehicleCode()
    {
        return $this->hasOne(mVehicleCode::class, 'vehicle_code', 'kode_ref');
    }

    public function toPWarna()
    {
        return $this->hasOne(mPWarna::class, 'id_warna', 'id_warna');
    }
}
