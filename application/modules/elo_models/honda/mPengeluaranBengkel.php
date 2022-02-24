<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mPengeluaranBengkel extends Model
{
    protected $table = 'db_honda.pengeluaran_bengkel';
    protected $primaryKey = 'no_pengeluaran';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_bukti_bku');
    }
}
