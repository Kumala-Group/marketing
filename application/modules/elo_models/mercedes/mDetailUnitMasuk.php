<?php

namespace app\modules\elo_models\mercedes;

use Illuminate\Database\Eloquent\Model;

class mDetailUnitMasuk extends Model
{
    protected $table = 'db_mercedes.detail_unit_masuk';
    protected $primaryKey = 'no_rangka';
    protected $keyType = 'string';
}