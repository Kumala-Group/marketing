<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mTargetUnit extends Model
{
    protected $table = 'db_honda_as.master_target_unit';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'nilai','tahun','bulan'
    ];
}
