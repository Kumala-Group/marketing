<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mImgGaleri extends Model
{
    protected $table = 'kumk6797_kumalagroup.image_galeri';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id_ref',
        'jenis',
        'img'
    ];
}
