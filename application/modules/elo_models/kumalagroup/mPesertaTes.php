<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mPesertaTes extends Model
{
    protected $table = 'kumalagroup.peserta_tes';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'karyawan_id',
        'pelamar_id',
        'email',
        'kategori'
    ];

}
