<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tugas;
use DB;
use File;

class TugasController extends Controller
{
    //
    public function index($id){
    	$tugas = DB::table('tugas')->select('*')->get();
    	// dd($tugas);	
    	return view('users/admin/surat_tugas/tugas/index', compact('tugas'));
    }

    public function store($id, Request $request){
    	$db = new Tugas;
		$db->id = $this->autocode('TGS');
		$db->nama = $request->nama;
		$db->id_surat = $id;
		$db->save();
		return back();
    }

    public function update(Request $request){
    	$db = Tugas::where('id', $request->id)->first();
		$db->nama = $request->nama;
		$db->save();
		return back();
    }

    public function delete(Request $request){
    	DB::table('tugas')->where('id', $request->id)->delete();
    	return back();
    }

	public function autocode($kode){
		$timestamp = time(); 
		$random = rand(10, 100);
		$current_date = date('mdYs'.$random, $timestamp); 
		return $kode."-".$current_date;
	}  

}

