<?php

namespace app\modules\elo_models\mercedes;

use Illuminate\Database\Eloquent\Model;

class mBukuBesar extends Model
{
    protected $table = 'db_mercedes.buku_besar';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $fillable = ["kode_module", "no_transaksi", "tgl", "kode_akun", "id_perusahaan", "id_bank", "dk", "jumlah", "keterangan", "w_insert", "user", "jb", "journal", "no_clearing", "tgl_clearing", "user_clearing", "dept", "no_ref", "closing"];
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';


    // public function toInvoiceAfterSales()
    // {
    //     return $this->hasOne(mInvoiceAfterSales::class, 'no_invoice', 'no_transaksi');
    // }

    // public function toPenerimaanBengkel()
    // {
    //     return $this->hasOne(mPenerimaanBengkel::class, 'no_penerimaan', 'no_transaksi');
    // }
}
