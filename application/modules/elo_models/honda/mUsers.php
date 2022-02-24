<?php

namespace app\modules\elo_models\honda;
use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mUsers extends Model
{
    protected $table = 'db_honda.users';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'nik', 'nik');
    }
}
