<?php

namespace app\modules\elo_models\kmg;

use Illuminate\Database\Eloquent\Model;

class mBrand extends Model
{
    protected $table = 'brand';
    protected $primaryKey = 'id_brand';
    protected $keyType = 'integer';

    public function toPerusahaan()
    {
        return $this->hasMany(mPerusahaan::class, 'id_brand', 'id_brand');
    }
}
