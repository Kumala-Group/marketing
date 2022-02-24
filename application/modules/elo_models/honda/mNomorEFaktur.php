<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mNomorEFaktur extends Model
{
    protected $table = 'db_honda.nomor_e_faktur';
    protected $primaryKey = 'id_e_faktur';
    protected $keyType = 'integer';
    protected $fillable = ["no_e_faktur", "no_transaksi", "status", "id_user"];
    const CREATED_AT = 'ins';
    const UPDATED_AT = 'upd';
}
