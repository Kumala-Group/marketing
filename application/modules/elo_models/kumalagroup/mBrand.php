<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mBrand extends Model
{
    protected $table = 'kumk6797_kumalagroup.brands';

    public function toUnit()
    {
        return $this->hasMany(mUnit::class, 'brand', 'id');
    }
}
