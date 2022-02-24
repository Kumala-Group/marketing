<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mLayanan extends Model
{
    protected $table = 'kumalagroup.layanan';

    public function toUnit()
    {
        return $this->hasOne(mUnit::class, 'id', 'unit');
    }
}
