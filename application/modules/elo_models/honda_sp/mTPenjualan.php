<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mTPenjualan extends Model
{
    protected $table = 'db_honda_sp.t_penjualan';
    protected $primaryKey = 'id_t_penjualan';
    protected $keyType = 'integer';

}
