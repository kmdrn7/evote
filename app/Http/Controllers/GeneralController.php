<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;	
use Auth;
use App\Http\Requests;
use App\User;
use App\Dpt;

class GeneralController extends Controller{
    function time(){
    	return date("l, d M Y / h:i:s A");
    }
    function index(){
        $data = User::get()->count();
        if($data == 0){
            return view('install');
        }
        else{
            if(Auth::check()){
             return redirect('dashboard');
            }
            else{
             return redirect('login');
            }    
        }
    	
    }
    function addUserFirst(Request $req){
            if(User::get()->count() == 0){
                $nrp = $req->nrp;
                $pass = $req->password;
                $hak = $req->hak_akses;
                $data = Dpt::where('nrp', $nrp)->first();

                $add = new User;
                $add->nrp = $nrp;
                $add->password = Hash::make($pass);
                $add->hak_akses = $hak;
                $add->id_jurusan = $data->id_jurusan;
                $add->nama = $data->nama;
                $add->save();
        }
    }
}   
