<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAsn;
use Illuminate\Support\Facades\Http;
use DB;
use File;


class TugasAsnController extends Controller
{
    public function index($id){
        $link = env("API_SMARTASN");
        $response = Http::get($link.'/api/surat_tugas/'.$id.'/asn_bertugas')->json();
        $asn = $response['asn'];
        $response = Http::get($link.'/api/get_asn/'.Auth()->user()->opd_id)->json();
        $data_asn = $response['asn'];
    	return view('users/admin/surat_tugas/tugas_asn/index', compact('asn', 'data_asn', 'id'));
    }


}
