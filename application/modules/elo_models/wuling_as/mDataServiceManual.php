<?php

namespace app\modules\elo_models\wuling_as;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\wuling\mBukuBesar;

class mDataServiceManual extends Model
{
    protected $table = 'db_wuling_as.data_service_manual';
    protected $primaryKey = 'no_invoice';
    protected $keyType = 'string';

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, "no_transaksi", "no_invoice");
    }
    // protected $fillable = ["id_detail_jasa", "id_jasa", "id_type", "durasi", "price"];
}
