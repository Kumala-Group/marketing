<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mPenerimaanUnit extends Model
{
    protected $table = 'db_hino.penerimaan_unit';
    protected $primaryKey = 'no_penerimaan';
    protected $keyType = 'string';

    public function toPenerimaanUnitDetail()
    {
        return $this->hasMany(mPenerimaanUnitDetail::class, 'no_penerimaan', 'no_penerimaan');
    }

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_penerimaan');
    }
}
