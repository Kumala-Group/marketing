<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mUcUnit extends Model
{
    protected $table = 'kumk6797_kumalagroup.uc_unit';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'nama',
        'slug',
        'brand',
        'warna',
        'tahun',
        'kilometer',
        'transmisi',
        'bahan_bakar',
        'tempat_duduk',
        'dimensi',
        'harga',
        'deskripsi',
        'gambar',
        'video',
        'lokasi'
    ];

    public function toGaleri()
    {
        return $this->hasMany(mImgGaleri::class, 'id_ref', 'id');
    }
}
