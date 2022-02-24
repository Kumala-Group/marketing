<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\mercedes\mBukuBesar;

class mDataServiceManual extends Model
{
    protected $table = 'db_mercedes_as.data_service_manual';
    protected $primaryKey = 'no_invoice';
    protected $keyType = 'string';

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, "no_transaksi", "no_invoice");
    }
    // protected $fillable = ["id_detail_jasa", "id_jasa", "id_type", "durasi", "price"];
}
