<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mUnit extends Model
{
    protected $table = 'kumk6797_kumalagroup.units';

    public function toBrand()
    {
        return $this->hasOne(mBrand::class, 'id', 'brand');
    }
    public function toModel()
    {
        return $this->hasOne(mModel::class, 'id', 'model');
    }
}
