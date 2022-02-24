<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mPaketPerawatanMaster extends Model
{
    protected $table = 'db_honda_as.paket_perawatan_master';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toJasaDetail()
    {
        return $this->hasMany(mPaketPerawatanJasaDetail::class, 'paket_perawatan_id', 'id');
    }

    public function toSvcatCode()
    {
        return $this->hasOne(mSvcatCode::class, 'kode', 'svcatcode');
    }

    public function toPartDetail()
    {
        return $this->hasMany(mPaketPerawatanPartDetail::class, 'paket_perawatan_id', 'id');
    }
}
