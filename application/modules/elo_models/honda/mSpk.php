<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mSpk extends Model
{
    protected $table = 'db_honda.s_spk';
    protected $primaryKey = 'id_prospek';
    protected $keyType = 'string';


    public function toCustomer()
    {
        return $this->hasOne(mCustomer::class, 'id_prospek', 'id_prospek');
    }
}
