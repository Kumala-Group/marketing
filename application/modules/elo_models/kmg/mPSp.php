<?php

namespace app\modules\elo_models\kmg;

use Illuminate\Database\Eloquent\Model;

class mPSp extends Model
{
    protected $table = 'p_sp';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = array('nama_sp', 'deskripsi');
}
