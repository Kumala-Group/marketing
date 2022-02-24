<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda\mUsers;
use app\modules\elo_models\honda_sp\mItem;
use app\modules\elo_models\kmg\mKaryawan;
use Illuminate\Database\Eloquent\Model;

class mWoDetailPart extends Model
{
    protected $table = 'db_honda_as.wo_detail_part';
    protected $primaryKey = 'id_detail_part_wo';
    protected $keyType = 'integer';

    public function toItem()
    {
        return $this->hasOne(mItem::class, 'kode_item', 'kode_item');
    }

    public function toKaryawan()
    {
        return $this->hasOne(mKaryawan::class, 'id_karyawan', 'used');
    }

    public function toWorkOrder()
    {
        return $this->hasOne(mWorkOrder::class, 'no_wo', 'no_wo');
    }

    public function scopeScpTelahAlokasiWo($query)
    {
        return $query->whereDel('0')->whereSRequest('2');
    }
}
