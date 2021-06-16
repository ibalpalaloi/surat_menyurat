<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat_tugas;
use Illuminate\Support\Facades\Http;
use DB;
use File;
class SuratTugasController extends Controller
{
    //
	public function index(){
		$link = env("API_SMARTASN");
		$response = Http::get($link.'/api/surat-tugas')->json();
		$surat_tugas = $response['surat_tugas'];
		// dd($surat_tugas);
		return view('users/admin/surat_tugas/index', compact('surat_tugas'));
	}

	public function store(Request $request){
		$link = env("API_SMARTASN");
		$status = "";
		$upload_berkas = "";
		if ($request->file('berkas_surat_tugas')){
			$file = $request->file('berkas_surat_tugas');
			$id = $this->autocode('FTG');
			$filename = File::extension($file->getClientOriginalName());
			$upload_berkas  = $id.".".$filename;
			\Storage::disk('public')->put('berkas_tugas/'.$id.".".$filename, file_get_contents($file));
			$status = "Surat tugas fisik lengkap";
		}
		else {
			$status = "Surat tugas fisik menyusul";
		}

		$response = Http::post($link."/api/surat-tugas/store", [
			'nomor' => $request->nomor_surat,
			'id_opd' => "OPD",
			'status' => $status,
			'username' => 'username',
			'upload_berkas' => $upload_berkas,
		])->json();

		return redirect('/surat-tugas');
	}

	public function autocode($kode){
		$timestamp = time(); 
		$random = rand(10, 100);
		$current_date = date('mdYs'.$random, $timestamp); 
		return $kode."-".$current_date;
	}  
}
