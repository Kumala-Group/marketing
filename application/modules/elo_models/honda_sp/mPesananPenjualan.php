<?php

namespace app\modules\elo_models\honda_sp;

use app\modules\elo_models\honda_as\mInvoiceAfterSales;
use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\kmg\mKaryawan;

class mPesananPenjualan extends Model
{
    protected $table = 'db_honda_sp.pesanan_penjualan';
    protected $primaryKey = 'id_pesanan_penjualan';
    protected $keyType = 'integer';

    public function toPelanggan()
    {
        return $this->hasOne(mPelanggan::class, 'kode_pelanggan', 'kode_pelanggan');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'admin');
    }

    public function toPenjualan()
    {
        return $this->hasMany(mPenjualan::class, "id_pesanan_penjualan", "id_pesanan_penjualan");
    }

    public function toInvoice()
    {
        return $this->hasOne(mInvoiceAfterSales::class, "no_ref", "no_transaksi");
    }
}
