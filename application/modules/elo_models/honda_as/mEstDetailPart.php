<?php

namespace app\modules\elo_models\honda_as;

use app\modules\elo_models\honda_sp\mItem;
use Illuminate\Database\Eloquent\Model;

class mEstDetailPart extends Model
{
    protected $table = 'db_honda_as.est_detail_part';
    protected $primaryKey = 'id_detail_part_est';
    protected $keyType = 'integer';

    public function toItem()
    {
        return $this->hasOne(mItem::class, 'kode_item', 'kode_item');
    }
}
