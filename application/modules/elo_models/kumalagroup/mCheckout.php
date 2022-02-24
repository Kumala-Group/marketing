<?php

namespace app\modules\elo_models\kumalagroup;

use Illuminate\Database\Eloquent\Model;

class mCheckout extends Model
{
    protected $table = 'kumalagroup.checkout';

    public function toKeranjang()
    {
        return $this->hasMany(mKeranjang::class, 'kode_checkout', 'kode');
    }
}
