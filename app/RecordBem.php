<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordBem extends Model
{
    protected $table = 'record_bem';
    protected $fillable = ['candidate_id'];
}
