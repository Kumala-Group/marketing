<?php

namespace app\modules\elo_models\honda_as;

use Illuminate\Database\Eloquent\Model;

class mFooterNote extends Model
{
    protected $table = 'db_honda_as.footer_inv';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
    
    protected $fillable = [
        'teks',
        'is_aktif',
        'id_perusahaan'
    ];
}
