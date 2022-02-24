<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnitModel extends Model
{
    protected $table = 'uc_unit';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    public function toGaleri()
    {
        return $this->hasMany(GaleriModel::class, 'id_ref', 'id');
    }
}
