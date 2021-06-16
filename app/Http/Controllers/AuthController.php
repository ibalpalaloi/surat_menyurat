<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Opd;
use DB;


class AuthController extends Controller
{
    //
    public function login(){
        return view('auth.login');
    }

    public function create_opd(){
		$link = env("API_SMARTASN");
		$response = Http::get($link.'/api/data-opd')->json();
		$opd = $response['opd'];
		// dd($opd);


    	return view('auth.create_opd', compact('opd'));
    }

    public function pilih_opd(Request $request){
    	$db = new Opd;
    	$db->id_opd = $request->opd;
    	$db->save();
    	return redirect('/');
    }
}
