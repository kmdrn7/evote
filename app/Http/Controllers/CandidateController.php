<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bem;
use App\Dpm;
use App\Dpt;
use App\Log;
use App\User;
use App\Http\Requests;
use Auth;

class CandidateController extends Controller
{
    function addPresBem(Request $req){
    	$nrp = $req->nrp;
    	$visi = $req->visi;
        $candidate_id = $req->candidate_id;
        $foto = $candidate_id.'_'.$nrp.'.'.$req->file('foto')->getClientOriginalExtension();
        $req->file('foto')->move(base_path() . '/public/presbem/', $foto);
        $nama = Dpt::where('nrp', $nrp)->first();

    	$add = new Bem;
    	$add->nrp = $nrp;
    	$add->visi = $visi;
    	$add->foto = $foto;
        $add->nama = $nama->nama;
        $add->candidate_id = $candidate_id;
    	$add->save();

        $data = Dpt::where('nrp', $nrp)->first();

        $nrp_usr = Auth::user()->nrp;
        $user = User::where('nrp', $nrp_usr)->first();

        $log = new Log;
        $log->nrp = $nrp_usr;
        $log->aktivitas = $user->nama.'('.$nrp_usr.') Menambahkan Kandidat PresBEM '.$data->nama.' ('.$data->nrp.')';
        $log->save();

    	return response()->json($data);
    }
    function addDpm(Request $req){
    	$nrp = $req->nrp;
        $visi = $req->visi;
        $candidate_id = $req->candidate_id;
        $id_jurusan = $req->id_jurusan;
        $foto = $candidate_id.'_'.$nrp.'.'.$req->file('foto')->getClientOriginalExtension();
        $req->file('foto')->move(base_path() . '/public/dpm/', $foto);
        $nama = Dpt::where('nrp', $nrp)->first();

        $add = new Dpm;
        $add->nrp = $nrp;
        $add->visi = $visi;
        $add->foto = $foto;
        $add->candidate_id = $candidate_id;
        $add->nama = $nama->nama;
        $add->id_jurusan = $id_jurusan;
        $add->save();

        $data = Dpm::where('nrp', $nrp)->first();


        $nrp_usr = Auth::user()->nrp;
        $user = User::where('nrp', $nrp_usr)->first();

        $log = new Log;
        $log->nrp = $nrp_usr;
        $log->aktivitas = $user->nama.'('.$nrp_usr.') Menambahkan Kandidat DPM '.$data->nama.' ('.$data->nrp.')';
        $log->save();

        return response()->json($data);
    }
}
