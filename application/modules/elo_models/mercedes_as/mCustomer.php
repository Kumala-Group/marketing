<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mCustomer extends Model
{
    protected $table = 'db_mercedes_as.customer';
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';
}
