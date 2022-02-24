<?php

namespace app\modules\elo_models\hino;

use Illuminate\Database\Eloquent\Model;

class mClosingLt extends Model
{
    protected $table = 'db_hino.closing_lt';
    protected $primaryKey = 'id_closing';
    protected $keyType = 'integer';
}
