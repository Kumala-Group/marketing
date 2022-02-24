<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mSvcatCode extends Model
{
    protected $table = 'db_honda_as.svcatcode';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toPmp()
    {
        return $this->hasOne(mSvcatCodePmp::class, 'kode', 'pmp_kode');
    }
    public function toType()
    {
        return $this->hasOne(mSvcatCodeType::class, 'kode', 'type_kode');
    }
    public function toKm()
    {
        return $this->hasOne(mSvcatCodeKm::class, 'kode', 'km_kode');
    }
    public function toFrtRef()
    {
        return $this->hasMany(mSvcatCodeFrtRef::class, 'svcatcode', 'kode');
    }
}
