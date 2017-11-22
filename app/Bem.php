<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bem extends Model
{
    protected $table = 'candidates_bem';

    protected $fillable = ['nrp','candidate_id','foto', 'visi','nama'];

    public $timestamps = false;
}
