<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Device;

class DeviceController extends Controller
{
    public function check($host) {
        exec(sprintf('ping -c 2 -i 1 %s', escapeshellarg($host)), $res, $rval);
        return response()->json(["status"=>$rval===0?"Aktif":"Down"]);
    }

    public function connect() {
        $ip = $_SERVER['REMOTE_ADDR'];

        $device = Device::where('ip_address', $ip);
        if($device->count()==0)
        {
        	$bilik = intval(Device::max('name'))+1;
            $device = new Device;
            $device->name = $bilik;
            $device->ip_address = $ip;
            $device->save();
        }

        return response()->json(["status"=>"berhasil"]);
    }

    public function checkBilik($host) {
    	$bilik = Device::where('ip_address', $host)->first();
    	return response()->json(['stat'=>$bilik->active_client==NULL?'Siap Digunakan':'Sedang Digunakan', 'nrp'=>$bilik->active_client==NULL?'':$bilik->active_client]);
    }
}
