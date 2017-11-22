<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpt extends Model
{
    protected $table = 'dpt';

    protected $fillable = [
        'nrp', 'nama', 'id_jurusan', 'id_kelas',
    ];

    public $timestamps = false;
}
