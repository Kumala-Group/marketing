<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mEstimasi extends Model
{
    protected $table = 'db_mercedes_as.estimasi';
    protected $primaryKey = 'no_estimasi';
    protected $keyType = 'string';
    protected $guarded = [];
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toPKategoriWo()
    {
        return $this->hasOne(mPKategoriWo::class, "kode_kategori_wo", "kode_paket_wo");
    }
}
