<?php

namespace app\modules\elo_models\mercedes_as;


use Illuminate\Database\Eloquent\Model;
use app\modules\elo_models\mercedes_sp\mItem;

class mWoDetailPart extends Model
{
    protected $table = 'db_mercedes_as.wo_detail_part';
    protected $primaryKey = 'id_detail_part_wo';
    protected $keyType = 'integer';

    public function toItem()
    {
        return $this->hasOne(mItem::class, 'kode_item', 'kode_item');
    }
}
