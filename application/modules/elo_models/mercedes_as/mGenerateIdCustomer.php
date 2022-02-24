<?php

namespace app\modules\elo_models\mercedes;

use Illuminate\Database\Eloquent\Model;

class mGenerateIdCustomer extends Model
{
    protected $table = 'db_mercedes_as.generate_id_customer';
    protected $primaryKey = 'id_customer';
    protected $keyType = 'string';
}
