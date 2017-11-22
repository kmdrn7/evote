<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Log;
use App\User;

class AuthController extends Controller
{
    function getLogin(){
    	return view('login');
    }
    function postLogin(Request $req){
    	$nrp = $req->nrp;
    	$pass = $req->password;

    	$user = Auth::attempt(['nrp' => $nrp, 'password' => $pass], true);
    	if ($user) {
            $user= User::where('nrp', $nrp)->first();
            switch ($user->hak_akses) {
                case 0:
                    $hak_akses = 'Administrator';
                    break;
                case 1:
                    $hak_akses = 'Observer';
                    break;
                case 2:
                    $hak_akses = 'Operator Registrasi';
                    break;
                case 3:
                    $hak_akses = 'Monitoring Room';
                    break;
                
                default:
                    break;
            }

            $add = new Log;
            $add->nrp = $nrp;
            $add->aktivitas = $user->nama.' ('.$nrp.') sebagai '.$hak_akses;
            $add->save();

            return redirect()->intended('dashboard');
        }
        else{
        	return redirect('login')->withErrors(array('unauth'=>'Invalid Login User!'));
        }
    }
    function logout(){
        $nrp = Auth::user()->nrp;
        $user= User::where('nrp', $nrp)->first();
        switch ($user->hak_akses) {
            case 0:
                $hak_akses = 'Administrator';
                break;
            case 1:
                $hak_akses = 'Observer';
                break;
            case 2:
                $hak_akses = 'Operator Registrasi';
                break;
            case 3:
                $hak_akses = 'Monitoring Room';
                break;
            
            default:
                break;
        }

        $add = new Log;
        $add->nrp = $nrp;
        $add->aktivitas = $user->nama.' ('.$nrp.') Logout sebagai '.$hak_akses;
        $add->save();

    	Auth::logout();
    	return redirect('login');
    }
}
