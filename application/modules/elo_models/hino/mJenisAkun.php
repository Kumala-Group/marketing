<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mJenisAkun extends Model
{
    protected $table = 'db_hino.jenis_akun';
    protected $primaryKey = 'id_jenis_akun';
    protected $keyType = 'integer';

    public function toAkun()
    {
        return $this->hasMany(mAkun::class, "id_jenis_akun", "id_jenis_akun");
    }
}
