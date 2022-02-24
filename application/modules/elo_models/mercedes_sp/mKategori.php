<?php

namespace app\modules\elo_models\mercedes_sp;

use Illuminate\Database\Eloquent\Model;

class mKategori extends Model
{
    protected $table = 'db_mercedes_sp.kategori';
    protected $primaryKey = 'id_kategori';
    protected $keyType = 'integer';
}
