<?php

namespace app\modules\elo_models\honda;

use Illuminate\Database\Eloquent\Model;

class mPenerimaanBengkelAlokasi extends Model
{
    protected $table = 'db_honda.penerimaan_bengkel_alokasi';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    protected $fillable = ["no_penerimaan", "no_ref", "jumlah_alokasi", "user", "keterangan"];

    public function toPenerimaanBengkel()
    {
        return $this->hasOne(mPenerimaanBengkel::class, 'no_penerimaan', 'no_penerimaan');
    }

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, 'no_transaksi', 'no_penerimaan');
    }
}
