<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mUnit extends Model
{
    protected $table = 'db_honda.unit';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toRekapInsentif()
    {
        return $this->hasMany(mRekapInsentif::class, 'id_type', 'id_type');
    }


    public function toVarian()
    {
        return $this->hasOne(mPustakaVarian::class, 'id_varian', 'id_varian');
    }

    public function toType()
    {
        return $this->hasOne(mPustakaVarian::class, 'id_type', 'id_type');
    }
}
