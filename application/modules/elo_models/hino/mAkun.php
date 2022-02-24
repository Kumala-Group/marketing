<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mAkun extends Model
{
    protected $table = 'db_hino.akun';
    protected $primaryKey = 'id_akun';
    protected $keyType = 'integer';

    public function toAkunSaldo()
    {
        return $this->hasMany(mAkunSaldo::class, "kode_akun", "kode_akun");
    }

    public function toBukuBesar()
    {
        return $this->hasMany(mBukuBesar::class, "kode_akun", "kode_akun");
    }

    public function toBukuBesarHpp()
    {
        return $this->hasMany(mBukuBesar::class, "kode_akun", "kode_akun")->whereKodeAkun("410100");
    }

    public function toBukuBesarDebit()
    {
        return $this->hasMany(mBukuBesar::class, "kode_akun", "kode_akun")->whereDk("d");
    }

    public function toBukuBesarKredit()
    {
        return $this->hasMany(mBukuBesar::class, "kode_akun", "kode_akun")->whereDk("k");
    }
}
