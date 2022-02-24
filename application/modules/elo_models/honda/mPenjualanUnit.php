<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mPenjualanUnit extends Model
{
    protected $table = 'db_honda.penjualan_unit';
    protected $primaryKey = 'no_transaksi';
    protected $keyType = 'string';

    public function toSpk()
    {
        return $this->hasOne(mSpk::class, 'no_spk', 'no_spk');
    }

    public function toDetailUnitMasuk()
    {
        return $this->hasOne(mDetailUnitMasuk::class, 'no_rangka', 'no_rangka');
    }
}
