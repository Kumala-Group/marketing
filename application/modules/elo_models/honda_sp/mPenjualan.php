<?php

namespace app\modules\elo_models\honda_sp;

use Illuminate\Database\Eloquent\Model;

class mPenjualan extends Model
{
    protected $table = 'db_honda_sp.penjualan';
    protected $primaryKey = 'id_penjualan';
    protected $keyType = 'integer';

    public function toItem()
    {
        return $this->hasOne(mItem::class, "kode_item", "kode_item");
    }

    public function toPesananPenjualan()
    {
        return $this->hasOne(mPesananPenjualan::class, "id_pesanan_penjualan", "id_pesanan_penjualan");
    }
}
