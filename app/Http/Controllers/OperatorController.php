<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dpt;
use App\Http\Requests;
use App\Jurusan;
use App\Kelas;

class OperatorController extends Controller
{
    function cariDpt(Request $req){
    	$data = Dpt::where('nrp', $req->nrp)->first();
    	$jurusan = Jurusan::where('id', $data->id_jurusan)->first();
		$kelas = Kelas::where('id', $data->id_kelas)->first();
    	
    	switch ($data->status_token) {
    		case 0:
    			$status = '<span class="label label-default" style="font-size: 11px">Belum diaktifkan</span>';
    			break;
    		case 1:
    			$status = '<span class="label label-success" style="font-size: 11px">Sudah Aktif</span>';
    			break;
    		case 2:
    			$status = '<span class="label label-danger" style="font-size: 11px">Kadaluarsa / Sudah dipakai</span>';
    			break;
    	}
    	if($data->end_time < time() && $data->status_token == 1){
    		$status = '<span class="label label-danger" style="font-size: 11px">Kadaluarsa / Sudah dipakai</span>';
		}

    	return response()->json(['data'=>$data, 'jurusan'=>$jurusan->jurusan, 'kelas'=>$kelas, 'status' => $status, 'value_token'=>$data->token]);
    }

    function genToken(Request $req){
    	$data = Dpt::where('nrp', $req->nrp)->first();
    	if($data->status_token == 0){
    		$token = str_random(5);
    		$time = (time()+600); //+n/60 adalah menit waktu hangus token
	    	Dpt::where('nrp', $req->nrp)->update(['token' => $token, 'status_token'=>1, 'end_time'=>$time]);
	    	$data = Dpt::where('nrp', $req->nrp)->first();
	    	switch ($data->status_token) {
	    		case 0:
	    			$status = '<span class="label label-default" style="font-size: 11px">Belum diaktifkan</span>';
	    			break;
	    		case 1:
	    			$status = '<span class="label label-success" style="font-size: 11px">Sudah Aktif</span>';
	    			break;
	    		case 2:
	    			$status = '<span class="label label-danger" style="font-size: 11px">Kadaluarsa / Sudah dipakai</span>';
	    			break;
	    	}
	    	return response()->json(['status'=>$status, 'value_token'=>$data->token]);
    	}
    }
}
