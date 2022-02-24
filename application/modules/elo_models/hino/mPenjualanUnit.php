<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mPenjualanUnit extends Model
{
    protected $table = 'db_hino.penjualan_unit';
    protected $primaryKey = 'no_transaksi';
    protected $keyType = 'string';
}
