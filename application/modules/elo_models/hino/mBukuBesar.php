<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mBukuBesar extends Model
{
    protected $table = 'db_hino.buku_besar';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function akunOtherExpense()
    {
        return $this->whereIn("kode_akun", ["910001", "910002", "910003", "910004", "910005", "910006", "910007", "910008", "910009", "910090", "999990"]);
    }

    public function akunOtherIncome()
    {
        return $this->whereIn("kode_akun", ["810001", "810002", "810003", "810004", "810005", "810006", "810007", "810090", "810091"]);
    }

    public function scopeAllBiaya($query)
    {
        return $query->whereIn("kode_akun", []);
    }

    public function scopeWhereNeraca($query, $tgl)
    {
        $query->where("tgl", "<=", $tgl);
    }
}
