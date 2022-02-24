<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mBookingServ extends Model
{
    protected $table = 'db_honda_as.booking_service';
    protected $primaryKey = 'kode_booking';
    protected $keyType = 'string';
    const CREATED_AT = 'w_insert'; 


    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, 'id_customer', 'id_customer');
    }

    public function toDetailUnitCustomer()
    {
        return $this->hasOne(mDetailUnitCustomer::class, 'no_rangka', 'no_rangka');
    }

}
