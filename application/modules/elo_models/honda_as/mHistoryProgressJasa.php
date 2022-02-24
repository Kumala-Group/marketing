<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mHistoryProgressJasa extends Model
{
    protected $table      = 'db_honda_as.history_progress_jasa';
    protected $primaryKey = 'id_history_jasa';
    protected $keyType    = 'integer';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    protected $fillable = ['id_detail_jasa_wo', 'foreman', 'id_mekanik', 'ts_foreman', 'ks_foreman', 'status'];

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, "id_karyawan", "id_mekanik");
    }

    public function toDetailJasa()
    {
        return $this->belongsTo(mWoDetailJasa::class, 'id_detail_jasa_wo', 'id_detail_jasa_wo');
    }
}
