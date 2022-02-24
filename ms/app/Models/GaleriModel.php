<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GaleriModel extends Model
{
    protected $table = 'image_galeri';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';
}
