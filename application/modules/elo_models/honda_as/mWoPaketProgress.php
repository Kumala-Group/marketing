<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mWoPaketProgress extends Model
{
    protected $table = 'db_honda_as.wo_paket_progress';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'id_karyawan', 'mekanik');
    }
    public function toPaket()
    {
        return $this->belongsTo(mWoPaket::class, 'id_paket', 'id');
    }
}
