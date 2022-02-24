<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mTarget extends Model
{
    protected $table = 'db_honda_as.master_target_weekly';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'nilai','tahun','bulan'
    ];
}
