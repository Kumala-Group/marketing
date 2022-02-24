<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mBrand extends Model
{
    protected $table = 'kumalagroup.brands';

    public function toUnit()
    {
        return $this->hasMany(mUnit::class, 'brand', 'id');
    }
}
