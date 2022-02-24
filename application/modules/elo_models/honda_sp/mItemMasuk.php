<?php

namespace app\modules\elo_models\honda_sp;

use app\modules\elo_models\honda\mBukuBesar;
use Illuminate\Database\Eloquent\Model;


class mItemMasuk extends Model
{
    protected $table = 'db_honda_sp.item_masuk';
    protected $primaryKey = 'id_item_masuk';
    protected $keyType = 'integer';


    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_invoice');
    }

    public function toItemMasukDetail()
    {
        return $this->hasMany(mItemMasukDetail::class, 'id_item_masuk', 'id_item_masuk');
    }

    public function toPesananPembelian()
    {
        return $this->hasOne(mPesananPembelian::class, 'no_po', 'no_po');
    }
}
