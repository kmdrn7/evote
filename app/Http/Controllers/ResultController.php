<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Bem;
use App\Dpm;
use App\RecordBem;
use App\RecordDpm;
use App\Dpt;
use App\Jurusan;

class ResultController extends Controller
{
    function resLogin(Request $req) {
    	$nrp = $req->nrp;
    	$pass = $req->password;

    	if (!$req->session()->has('jml_obs')) {
		    $jml_obs= User::where('hak_akses', 1)->count();
		    $req->session()->put('jml_obs', $jml_obs);
		}
		$jml_obs = $req->session()->get('jml_obs');

		if($jml_obs > 0) {
	    	$user = Auth::attempt(['nrp' => $nrp, 'password' => $pass, 'hak_akses'=>1]);
	    	if ($user) {
	            $user= User::where('nrp', $nrp)->first();
	            
	            if (!$req->session()->has('obs_data')) {
				    $req->session()->put('obs_data', []);
				}
			    $req->session()->push('obs_data', ['nrp'=>$user->nrp, 'nama'=>$user->nama]);
			    $req->session()->put('jml_obs', --$jml_obs);

			    if (!$req->session()->has('jml_obs')) {
			    	$jml_login = 1;
				}

				$jml_login= $req->session()->get('jml_login');
			    $req->session()->put('jml_login', ++$jml_login);
			    Auth::logout();
			    return redirect('result');
	        }
	        else{
	        	return redirect('result')->withErrors(array('unauth'=>'Invalid Login User!'));
	        }
	    }
    }

    function hasil(Request $req){
    	if (!$req->session()->has('jml_obs')) {
    		return view('loginres');
    	}
    	else {
    		$jml_obs = $req->session()->get('jml_obs');
    		$jml_login = $req->session()->get('jml_login');
    		if($jml_obs == 0 && $jml_login > 0) {
	    		$data = [];
	    		$presbem = [];
	    		$dpm = [];
                $jurusan = Jurusan::get();

	    		$presbem[1]['data'] = Bem::where('candidate_id', 1)->first();
	    		$presbem[2]['data'] = Bem::where('candidate_id', 2)->first();
	    		$presbem[1]['jumlah'] = RecordBem::where('candidate_id', 1)->count();
	    		$presbem[2]['jumlah'] = RecordBem::where('candidate_id', 2)->count();
	    		$presbem[0]['jumlah'] = RecordBem::where('candidate_id', 0)->count() + Dpt::where('status_token', '!=', 0)->where('status_bem', 0)->count();
	    		$presbem['all']['jumlah'] = Dpt::where('status_token', '!=', 0)->count();
	    		$presbem['dipilih'] = $presbem[1]['jumlah']+$presbem[2]['jumlah'];
	    		$presbem[1]['keterangan'] = $presbem[1]['jumlah'] > $presbem[2]['jumlah'];
	    		$presbem[2]['keterangan'] = $presbem[2]['jumlah'] > $presbem[1]['jumlah'];

	    		for($i = 0; $i < 9; $i++) {
	    			$dpm[$i]['data'] = Dpm::where('id_jurusan', $i)->first();
	    			$dpm[$i]['jumlah'] = RecordDpm::where('id_jurusan', $i)->where('candidate_id', 1)->count();
	    			$dpm[$i]['abstain'] = RecordDpm::where('id_jurusan', $i)->where('candidate_id', 0)->count() + Dpt::where('id_jurusan', $i)->where('status_token', '!=', 0)->where('status_dpm', 0)->count();
	    			$data['dpt']['dpm'][$i] = RecordDpm::where('id_jurusan', $i)->count();
	    		}

	    		$data['presbem'] = $presbem;
	    		$data['dpm'] = $dpm;
	    		$data['jur'] = $jurusan;
	    		$data['dpt']['jumlah'] = Dpt::count();
	    		$data['dpt']['mendaftar'] = Dpt::where('status_token', '!=', 0)->count();
	    		$data['dpt']['tidak_daftar'] = Dpt::where('status_token', 0)->count();
	    		$data['dpt']['bem']['jumlah'] = Dpt::where('status_bem', 1)->count();
	    		$data['dpt']['bem']['abstain'] = Dpt::where('status_bem', 0)->count();
	    		$data['dpt']['dpm']['jumlah'] = Dpt::where('status_dpm', 1)->count();	  
	    		$data['dpt']['dpm']['abstain'] = Dpt::where('status_dpm', 0)->count();

    			return view('result', compact('data'));
    		}
    		elseif($jml_obs > 0) {
    			$data = $req->session()->get('obs_data');
    			$data = is_array($data)?array_pop($data):[];

    			return view('loginres', compact('data', 'jml_login'));
    		}
    	}
    }

    function logout(Request $req) {
    	$req->session()->flush();
    	return redirect('result');
    }
}
