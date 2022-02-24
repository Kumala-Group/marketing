<?php

namespace app\modules\elo_models\honda_sp;

use app\modules\elo_models\honda_as\mWoDetailPart;
use Illuminate\Database\Eloquent\Model;

class mItemMasukDetail extends Model
{
    protected $table = 'db_honda_sp.item_masuk_detail';
    protected $primaryKey = 'id_item_masuk_detail';
    protected $keyType = 'integer';

    public function toPembelian()
    {
        return $this->hasOne(mPembelian::class, 'id_pesanan_pembelian', 'id_pesanan_pembelian');
    }

    public function toPembelianByKodeItem()
    {
        return $this->hasMany(mPembelian::class, 'kode_item', 'kode_item');
    }

    public function toItem()
    {
        return $this->hasOne(mItem::class, 'kode_item', 'kode_item');
    }

    public function toItemMasukDetail()
    {
        return $this->hasMany(mItemMasukDetail::class, 'kode_item', 'kode_item');
    }

    public function toItemMasuk()
    {
        return $this->hasMany(mItemMasuk::class, 'id_item_masuk', 'id_item_masuk');
    }

    public function toWoDetailPart()
    {
        return $this->hasMany(mWoDetailPart::class, 'kode_item', 'kode_item');
    }
}
