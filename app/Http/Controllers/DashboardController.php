<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Hash;
use App\Http\Requests;
use App\User;
use App\Dpt;
use App\Jurusan;
use App\Kelas;
use App\Bem;
use App\Dpm;
use App\Device;
use App\Log;

class DashboardController extends Controller{
    function index(){
    	if (Auth::check()){
    		$user = Auth::user()->hak_akses;
    		if($user == 0 || $user == 1){
    			$man_user = User::get();
                $dpt = Dpt::get();
                $jurusan = Jurusan::get();
                $kelas = Kelas::get();
                $presbem = Bem::get();
                $dpm = Dpm::get();
                $device = Device::get();
                $log = Log::get();
                return view('dashboard', compact('man_user','user','dpt','jurusan','kelas','presbem','dpm', 'device', 'log'));
    		}
            elseif ($user == 2) {
                $device = Device::get();
                return view('dashboard',compact('device', 'user'));
            }  
            elseif ($user == 3) {
                $device = Device::get();
                return view('dashboard', compact('device', 'user'));
            } 
    	}
    	else{
    		return redirect('login')->withErrors(array('unauth'=>'Invalid Login User!'));
    	}
    }
    function addDpt(Request $req){
        $nrp = $req->nrp;
        $nama = $req->nama;
        $id_jurusan = $req->id_jurusan;
        $id_kelas = $req->id_kelas;
        

        $add = new Dpt;
        $add->nrp = $nrp;
        $add->nama = $nama;
        $add->id_kelas = $id_kelas;
        $add->id_jurusan = $id_jurusan;
        $add->save();
        $id = Dpt::count();
        $data = Dpt::where('nrp', $nrp)->first();
        $jurusan = Jurusan::where('id', $id_jurusan)->first();
        $kelas = Kelas::where('id', $id_kelas)->first();
        $nama_kelas = $kelas->tingkat." ".$kelas->jenjang." ".$kelas->kelas;

        $nrp_usr = Auth::user()->nrp;
        $user = User::where('nrp', $nrp)->first();

        $add = new Log;
        $add->nrp = $nrp_usr;
        $add->aktivitas = $user->nama.'('.$nrp_usr.') Menambahkan DPT '.$nama.' ('.$nrp.')';
        $add->save();

        return response()->json(['data'=>$data, 'jurusan'=>$jurusan->jurusan, 'kelas'=>$nama_kelas,'i'=>$id]);
    }
    function addUser(Request $req){
        $nrp = $req->nrp;
        $pass = $req->password;
        $hak = $req->hak_akses;
        $data = Dpt::where('nrp', $nrp)->first();
        $jurusan = Jurusan::find($data->id_jurusan)->jurusan;

        $add = new User;
        $add->nrp = $nrp;
        $add->password = Hash::make($pass);
        $add->hak_akses = $hak;
        $add->id_jurusan = $data->id_jurusan;
        $add->nama = $data->nama;
        $add->save();

        $id = User::get();
        switch($hak){
            case 0:
                $hak = "Administrator";
                break;
            case 1:
                $hak = "Observer";
                break;
            case 2:
                $hak = "Operator Registasi";
                break;
            case 3:
                $hak = "Monitoring Room";
                break;
        }
        $data = User::where('nrp', $nrp)->first();


        $nrp_usr = Auth::user()->nrp;
        $user = User::where('nrp', $nrp)->first();

        $add = new Log;
        $add->nrp = $nrp_usr;
        $add->aktivitas = $user->nama.'('.$nrp_usr.') Menambahkan User '.$data->nama.' ('.$data->nrp.')';
        $add->save();

        return response()->json(['id'=>$id->count(),'nama' => $data->nama,'nrp'=>$data->nrp, 'jurusan' => $jurusan,'hak_akses' => $hak]);
    }
}
