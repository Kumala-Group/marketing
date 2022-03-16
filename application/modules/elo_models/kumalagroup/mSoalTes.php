<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mSoalTes extends Model
{
    protected $table = 'kumk6797_kumalagroup.soal';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = ['text','file','opsi_a','opsi_b','opsi_c','opsi_d','opsi_d','file_a','file_b','file_c','file_d','file_e','jawaban'];

}
