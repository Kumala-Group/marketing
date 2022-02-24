<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mTPelangganPenjualan extends Model
{
    protected $table = 'db_honda_sp.t_pelanggan_penjualan';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';


    public function toPelanggan()
    {
        return $this->hasOne(mPelanggan::class, "kode_pelanggan", "kode_pelanggan");
    }
}
