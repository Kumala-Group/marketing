<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MazdaUnit extends Model
{
    protected $table      = 'units';
    protected $primaryKey = 'id';
    protected $keyType    = 'integer';

    public function toModels()
    {
        return $this->hasMany(MazdaModel::class,'id','model');
    }
}
