<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda_sp\mItem;
use Illuminate\Database\Eloquent\Model;

class mPaketPerawatanPartDetail extends Model
{
    protected $table = 'db_honda_as.paket_perawatan_part_detail';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toMaster()
    {
        return $this->belongsTo(mPaketPerawatanMaster::class, 'paket_perawatan_id', 'id');
    }

    public function toItem()
    {
        return $this->hasOne(mItem::class,'part_number','part_number');
        
    }
}
