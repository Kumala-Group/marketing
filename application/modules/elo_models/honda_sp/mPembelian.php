<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mPembelian extends Model
{
    protected $table = 'db_honda_sp.pembelian';
    protected $primaryKey = 'id_pembelian';
    protected $keyType = 'integer';
}
