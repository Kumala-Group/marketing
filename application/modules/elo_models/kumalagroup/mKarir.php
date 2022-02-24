<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mKarir extends Model
{
    protected $table = 'kumalagroup.karirs';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = array('posisi', 'jumlah', 'deskripsi','status');
}
