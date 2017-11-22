<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dpt;
use App\Http\Requests;
use App\RecordBem;
use App\RecordDpm;
use App\Device;
class AndroidController extends Controller
{
    function login(Request $req){
    	$nrp = $req->nrp;
    	$token = $req->token;

    	if(Dpt::where('nrp',$nrp)->where('token',$token)->count() == 1){
            $ip = $_SERVER['REMOTE_ADDR'];
    		$data = Dpt::where('nrp',$nrp)->first();	
    		$stat_token = $data->status_token;
    		$time = $data->end_time;
    		if($stat_token == 1 && time() < $time){
                Device::where('ip_address', $ip)->update(['active_client'=>$nrp]);
                Dpt::where('nrp', $nrp)->update(['status_token'=>2]);
    			return response()->json(['message'=>'Login Berhasil', 'error'=>false, 'id_jurusan'=>$data->id_jurusan]);
    		}
    		else if($stat_token == 2 || time() > $time){
    			return response()->json(['message'=>'Token Kadaluarsa', 'error'=>true]);
    		}
    	}
    	else{
    		return response()->json(['message'=>'Invalid Login','error'=>true]);
    	}
    }
    function voteBem(Request $req){
    	$nrp = $req->nrp;
    	$token = $req->token;
    	$vote = $req->vote;
    	if(Dpt::where('nrp',$nrp)->where('token',$token)->count() == 1){
    		$data = Dpt::where('nrp',$nrp)->first();	
    		$stat_token = $data->status_token;
            $stat_votebem = $data->status_bem;
    		$time = $data->end_time;
    		if($stat_token == 2 && time() < $time){
                $bem = new RecordBem;
                $bem->candidate_id=$vote;
                $bem->save();
                Dpt::where('nrp', $nrp)->update(['status_bem'=>1]);
                return response()->json(['message'=>'Telah memilih', 'error'=>false]);
    		}
    		else if($stat_votebem == 1 || time() > $time){
    			return response()->json(['message'=>'Token Kadaluarsa','error'=>true]);
    		}
    	}
    }
    function voteDpm(Request $req){
        $nrp = $req->nrp;
        $token = $req->token;
        $vote = $req->vote;
        if(Dpt::where('nrp',$nrp)->where('token',$token)->count() == 1){
            $data = Dpt::where('nrp',$nrp)->first();    
            $stat_token = $data->status_token;
            $stat_votedpm = $data->status_dpm;
            $id_jurusan = $data->id_jurusan;
            $time = $data->end_time;
            if($stat_token == 2 && time() < $time){
                $dpm = new RecordDpm;
                $dpm->candidate_id=$vote;
                $dpm->id_jurusan=$id_jurusan;
                $dpm->save();
                Dpt::where('nrp', $nrp)->update(['status_dpm'=>1]);
                return response()->json(['message'=>'Telah memilih', 'error'=>false]);
            }
            else if($stat_votedpm == 1 || time() > $time){
                return response()->json(['message'=>'Token Kadaluarsa','error'=>true]);
            }
        }
    }
    function logout(){
        $ip = $_SERVER['REMOTE_ADDR'];
        $nrp = Device::where('ip_address', $ip)->first();

        $data = Dpt::where('nrp', $nrp->active_client)->first();
        if($data->status_bem == 0){
            $bem = new RecordBem;
            $bem->candidate_id = 0;
            $bem->save();
            Dpt::where('nrp', $nrp)->update(['status_bem'=>1]);
        }
        if($data->status_dpm == 0){
            $dpm = new RecordDpm;
            $dpm->candidate_id = 0;
            $dpm->id_jurusan=$data->id_jurusan;
            $dpm->save();
            Dpt::where('nrp', $nrp)->update(['status_dpm'=>1]);
        }
        Device::where('ip_address', $ip)->update(['active_client'=>NULL]);
        return response()->json(['error'=>false]);
    }
}
