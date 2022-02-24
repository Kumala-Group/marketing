<?php

namespace app\modules\elo_models\honda;

use app\modules\elo_models\kmg\mJabatan;
use app\modules\elo_models\kmg\mKaryawan;
use app\modules\elo_models\kmg\mPerusahaan;
use Illuminate\Database\Eloquent\Model;

class mAdmSales extends Model
{
    protected $table = 'db_honda.adm_sales';
    protected $primaryKey = 'id_sales';
    protected $keyType = 'integer';

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'id_karyawan', 'id_sales');
    }

    public function toJabatan()
    {

        return $this->hasOne(mJabatan::class, 'id_jabatan', 'id_jabatan');
    }

    public function toPerusahaan()
    {

        return $this->hasOne(mPerusahaan::class, 'id_perusahaan', 'id_perusahaan');
    }
}
