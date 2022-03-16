<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mSlider extends Model
{
    protected $table = 'kumk6797_kumalagroup.sliders';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'kategori',
        'aksi',
        'gambar'
    ];
}
