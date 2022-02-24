<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KontakModel extends Model
{
    protected $table = 'contacts';
    protected $primaryKey = 'id';
    protected $keyType = 'integer';

    protected $fillable = ['nama', 'email', 'telepon', 'pesan', 'website'];
}
