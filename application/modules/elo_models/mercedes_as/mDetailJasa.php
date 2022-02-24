<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;

class mDetailJasa extends Model
{
    protected $table = 'db_mercedes_as.detail_jasa';
    protected $primaryKey = 'id_jasa';
    protected $keyType = 'integer';
    protected $fillable = ["id_detail_jasa", "id_jasa", "id_type", "durasi", "price"];
}
