<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mUnit extends Model
{
    protected $table = 'db_mercedes_as.unit';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toPModel()
    {
        return $this->hasOne(mPModel::class, 'id_model', 'id_model');
    }

    public function toPWarna()
    {
        return $this->hasOne(mPWarna::class, 'id_warna', 'id_warna');
    }

    public function toPType()
    {
        return $this->hasOne(mPType::class, 'id_type', 'id_type');
    }
}
