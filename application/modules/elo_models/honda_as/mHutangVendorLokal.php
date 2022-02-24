<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda\mBukuBesar;
use Illuminate\Database\Eloquent\Model;

class mHutangVendorLokal extends Model
{
    protected $table = 'db_honda_as.hutang_vendor_lokal';
    protected $primaryKey = 'no_po';
    protected $keyType = 'string';

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, "no_transaksi", "no_po");
    }
}
