<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mUnitDetail extends Model
{
    protected $table = 'kumk6797_kumalagroup.units_detail';

    protected $fillable = array('unit', 'detail', 'nama_detail', 'deskripsi', 'gambar');
}
