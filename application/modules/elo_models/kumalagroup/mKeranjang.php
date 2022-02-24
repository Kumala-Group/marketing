<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mKeranjang extends Model
{
    protected $table = 'kumalagroup.keranjang';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, 'id', 'unit');
    }
}
