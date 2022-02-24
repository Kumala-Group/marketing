<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mVendor extends Model
{
    protected $table = 'db_honda_as.vendor_master';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = [
        'id',
        'id_perusahaan',
        'nama'
    ];

    public function toPDataOpl()
    {
        return $this->hasOne(mPDataOpl::class, 'vendor', 'id');
    }

}
