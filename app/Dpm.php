<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dpm extends Model
{
    protected $table = 'candidates_dpm';

    protected $fillable = ['nrp','candidate_id','id_jurusan','foto','visi','nama'];

    public $timestamps = false;
}
