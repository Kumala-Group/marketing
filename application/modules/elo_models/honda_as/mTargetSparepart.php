<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mTargetSparepart extends Model
{
    protected $table = 'db_honda_as.master_target_sparepart';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'sp_workshop','aksesoris','oil_lubricant','tahun','bulan'
    ];
}
