<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mPesananPembelian extends Model
{
    protected $table = 'db_honda_sp.pesanan_pembelian';
    protected $primaryKey = 'id_pesanan_pembelian';
    protected $keyType = 'integer';

    public function toPembelian()
    {
        return $this->hasMany(mPembelian::class, 'id_pesanan_pembelian', 'id_pesanan_pembelian');
    }
}
