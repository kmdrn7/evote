<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordDpm extends Model
{
    protected $table = 'record_dpm';
    protected $fillable = ['candidate_id','id_jurusan'];
}
