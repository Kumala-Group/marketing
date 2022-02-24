<?php

namespace app\modules\elo_models\kmg;

use app\modules\elo_models\wuling\mKodeCabangSGMW;
use Illuminate\Database\Eloquent\Model;

class mPerusahaan extends Model
{
    protected $table = 'perusahaan';
    protected $primaryKey = 'id_perusahaan';
    protected $keyType = 'integer';

    public function toKodeSGMW()
    {
        return $this->hasOne(mKodeCabangSGMW::class,'id_perusahaan','id_perusahaan');
    }
}
