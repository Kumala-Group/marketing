<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mDealers extends Model
{
    protected $table = 'kumk6797_kumalagroup.dealers';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id_perusahaan',
        'area',
        'brand',
        'alamat',
        'judul',
        'gambar',
        'map'
    ];
}
