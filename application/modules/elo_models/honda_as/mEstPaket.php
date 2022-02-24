<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mEstPaket extends Model
{
    protected $table = 'db_honda_as.est_paket';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toPaketMaster()
    {
        return $this->hasOne(mPaketPerawatanMaster::class, 'id', 'id_paket_perawatan');
    }
}
