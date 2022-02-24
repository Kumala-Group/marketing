<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mAkunSaldo extends Model
{
    protected $table = 'db_hino.akun_saldo';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
}
