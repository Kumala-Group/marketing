<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mCustomer extends Model
{
    protected $table = 'db_honda.s_customer';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';

    public function toSales()
    {
        return $this->hasOne(mAdmSales::class, 'id_sales', 'sales');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'id_karyawan', 'sales');
    }
}
