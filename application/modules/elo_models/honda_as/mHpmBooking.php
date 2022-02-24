<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mHpmBooking extends Model
{
    protected $table = 'db_honda_as.hpm_booking';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'user');
    }
    
}
