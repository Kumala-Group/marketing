<?php

namespace app\modules\elo_models\mercedes_as;

use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mHistoryProgressJasa extends Model
{
    protected $table = 'db_mercedes_as.history_progress_jasa';
    protected $primaryKey = 'id_history_jasa';
    protected $keyType = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, "id_karyawan", "id_mekanik");
    }
}
