<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mPenerimaanBengkel extends Model
{
    protected $table = 'db_honda.penerimaan_bengkel';
    protected $primaryKey = 'no_penerimaan';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert';
    const UPDATED_AT = 'w_update';

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_penerimaan');
    }

    public function toPenerimaanBengkelDetail()
    {
        return $this->hasMany(mPenerimaanBengkelDetail::class, 'no_penerimaan', 'no_penerimaan');
    }

    public function toPenerimaanBengkelAlokasi()
    {
        return $this->hasMany(mPenerimaanBengkelAlokasi::class, 'no_penerimaan', 'no_penerimaan');
    }
}
