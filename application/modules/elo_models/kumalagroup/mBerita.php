<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mBerita extends Model
{
    protected $table = 'kumalagroup.beritas';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'type',
        'website',
        'judul',
        'slug',
        'deskripsi',
        'thumb',
        'gambar'
    ];
}
