<?php

namespace app\modules\elo_models\mercedes_as;

use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\mercedes_as\mDetailJasa;

class mJasa extends Model
{
    protected $table = 'db_mercedes_as.jasa';
    protected $primaryKey = 'id_jasa';
    protected $keyType = 'integer';
    protected $fillable = ["kode_jasa", "id_region", "id_p_nama_jasa", "id_p_kategori_wo", "desc_jasa", "jenis"];

    public function toDetailJasa()
    {
        return $this->hasMany(mDetailJasa::class, 'id_jasa', 'id_jasa');
    }

    public function toPNamaJasa()
    {
        return $this->hasOne(mPNamaJasa::class, 'id_p_nama_jasa', 'id_p_nama_jasa');
    }
}
