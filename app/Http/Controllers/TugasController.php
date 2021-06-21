<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use Illuminate\Support\Facades\Http;
use DB;
use File;

class TugasController extends Controller
{
    //
    public function index($id){
    	$link = env('API_SMARTASN');
		$response = Http::get($link.'/api/tugas_surat_tugas',[
			'id_surat' => $id
		])->json();
    	$tugas = $response['tugas'];
    	return view('users/admin/surat_tugas/tugas/index', compact('tugas'));
    }

    public function store($id, Request $request){
    	$link = env('API_SMARTASN');
		$response = Http::get($link.'/api/tambah_tugas_surat_tugas', [
			'id_surat_tugas' => $id,
			'tugas' => $request->tugas
		])->json();
		return back();
    }

    public function update(Request $request){
    	$link = env('API_SMARTASN');
		$response = Http::get($link.'/api/ubah_tugas_surat_tugas', [
			'id_tugas' => $request->id,
			'tugas' => $request->nama
		])->json();
		return back();
    }

    public function delete(Request $request){
    	$link = env('API_SMARTASN');
		$response = Http::get($link.'/api/hapus_tugas_surat_tugas', [
			'id_tugas' => $request->id,
		])->json();
		return back();
    }

	public function autocode($kode){
		$timestamp = time(); 
		$random = rand(10, 100);
		$current_date = date('mdYs'.$random, $timestamp); 
		return $kode."-".$current_date;
	}  

}

