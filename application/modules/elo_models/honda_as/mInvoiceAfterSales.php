<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda\mBukuBesar;
use app\modules\elo_models\honda\mNomorEFaktur;
use app\modules\elo_models\honda_sp\mPesananPenjualan;
use Illuminate\Database\Eloquent\Model;

class mInvoiceAfterSales extends Model
{
    protected $table = 'db_honda_as.invoice_after_sales';
    protected $primaryKey = 'no_invoice';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';


    public function toNomorEFaktur()
    {
        return $this->hasOne(mNomorEFaktur::class, "no_transaksi", "no_invoice");
    }

    public function toPesananPenjualan()
    {
        return $this->hasOne(mPesananPenjualan::class, "no_transaksi", "no_ref");
    }

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, "no_transaksi", "no_invoice");
    }
    
    public function toWorkOrder()
    {
        return $this->hasOne(mWorkOrder::class, 'no_wo', 'no_ref');
    }
}
