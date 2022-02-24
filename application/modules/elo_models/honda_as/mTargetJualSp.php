<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mTargetJualSp extends Model
{
    protected $table = 'db_honda_as.master_target_jual_sparepart';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'workshop','counter','eksternal','tahun','bulan'
    ];
}
