<?php

namespace App\Http\Controllers\Api\ClientSmartAsn;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Absen_code;
use App\Models\Absen;
use DB;

class AbsenController extends Controller
{

	public function check_jumat($hari){
		if ($hari == 'Fri'){
			$jumat = "Ya";				
		}
		else {
			$jumat = "Tidak";								
		}
		return $jumat;		
	}

	public function check_waktu($waktu){
		$batas_pagi = DB::table('jadwal_absens')->select('jam_awal')->where('status', 'Hadir')->where('status_absen', 'Pagi')->first()->jam_awal;
		$batas_sore = DB::table('jadwal_absens')->select('jam_akhir')->where('status', 'Hadir')->where('status_absen', 'Sore')->first()->jam_akhir;

		if (($waktu >= date('H:i:s', strtotime("00:00:01"))) && ($waktu <= $batas_pagi)){
			$status = "Subuh";
		}
		else if(($waktu >= $batas_pagi) && ($waktu <= date('H:i:s', strtotime("12:00:00")))){
			$status = "Pagi";
		}
		else if(($waktu >= date('H:i:s', strtotime("12:00:00"))) && ($waktu <= $batas_sore)){
			$status = "Sore";
		}
		else {
			$status = "Malam";
		}
		return $status;
	}


	public function jadwal_absen_pagi($waktu, $jumat, $current_date, $id_login){
		$jadwal_absen = array();
		$pagi = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'status_absen', 'level', 'status')->where('status_absen', 'Pagi')->where('jumat', $jumat)->get();
		foreach ($pagi as $row){
			if (($waktu >= $row->jam_awal) && ($waktu <= $row->jam_akhir)){
				$jadwal_absen["Pagi"]["jam_awal"] = $row->jam_awal;
				$jadwal_absen["Pagi"]["jam_akhir"] = $row->jam_akhir;
				$jadwal_absen["Pagi"]["level"] = $row->level;
				$jadwal_absen["Pagi"]["status"] = $row->status;
				$jadwal_absen["Pagi"]["keterangan"] = "";
				$jadwal_absen["Pagi"]["is_absen"] = "Ya";
			}
		}

		$sore = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'status_absen', 'level', 'status')->where('status_absen', 'Sore')->where('jumat', $jumat)->orderBy('jam_akhir', 'desc')->first();
		$jadwal_absen["Sore"]["jam_awal"] = $sore->jam_awal;
		$jadwal_absen["Sore"]["jam_akhir"] = $sore->jam_akhir;
		$jadwal_absen["Sore"]["level"] = $sore->level;
		$jadwal_absen["Sore"]["status"] = $sore->status;
		$jadwal_absen["Sore"]["keterangan"] = "";
		$jadwal_absen["Sore"]["is_absen"] = "Tidak";

		// Check kehadiran
		$session_absen = array('Pagi', 'Sore');
		for ($j = 0; $j < count($session_absen); $j++){
			foreach ($jadwal_absen[$session_absen[$j]] as $row){
				$status_absen = DB::table('absens')->select('id', 'waktu', 'status')->where('id_login', $id_login)->where('tanggal', $current_date)->where('status_absen', $session_absen[$j])->first();
				if ($status_absen){
					$jadwal_absen["Pagi"]["is_absen"] = "Tidak";
					$jadwal_absen[$session_absen[$j]]['waktu_absen'] = $status_absen->waktu;
					$jadwal_absen[$session_absen[$j]]["keterangan"] = $status_absen->status;

				}
				else {					
					$jadwal_absen[$session_absen[$j]]['waktu_absen'] = "belum_absen";
				}
			}
		}				
		return $jadwal_absen;
	}

	public function jadwal_absen_sore($waktu, $jumat, $current_date, $id_login){
		$jadwal_absen = array();
		$pagi = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'status_absen', 'level', 'status')->where('status_absen', 'Pagi')->where('jumat', $jumat)->orderBy('jam_akhir', 'desc')->first();
		$jadwal_absen["Pagi"]["jam_awal"] = $pagi->jam_awal;
		$jadwal_absen["Pagi"]["jam_akhir"] = $pagi->jam_akhir;
		$jadwal_absen["Pagi"]["level"] = $pagi->level;
		$jadwal_absen["Pagi"]["status"] = $pagi->status;
		$jadwal_absen["Pagi"]["keterangan"] = "";
		$jadwal_absen["Pagi"]["is_absen"] = "Tidak";

		$sore = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'status_absen', 'level', 'status')->where('status_absen', 'sore')->where('jumat', $jumat)->get();
		foreach ($sore as $row){
			if (($waktu >= $row->jam_awal) && ($waktu <= $row->jam_akhir)){
				$jadwal_absen["Sore"]["jam_awal"] = $row->jam_awal;
				$jadwal_absen["Sore"]["jam_akhir"] = $row->jam_akhir;
				$jadwal_absen["Sore"]["level"] = $row->level;
				$jadwal_absen["Sore"]["status"] = $row->status;
				$jadwal_absen["Sore"]["keterangan"] = $row->status." ".$row->level;
				$jadwal_absen["Sore"]["is_absen"] = "Ya";
			}
		}

		// Check kehadiran
		$session_absen = array('Pagi', 'Sore');
		for ($j = 0; $j < count($session_absen); $j++){
			foreach ($jadwal_absen[$session_absen[$j]] as $row){
				$status_absen = DB::table('absens')->select('id', 'waktu', 'status')->where('id_login', $id_login)->where('tanggal', $current_date)->where('status_absen', $session_absen[$j])->first();
				if ($status_absen){
					// dd($status_absen);
					$jadwal_absen[$session_absen[$j]]["is_absen"] = "Tidak";
					$jadwal_absen[$session_absen[$j]]['waktu_absen'] = $status_absen->waktu;
					$jadwal_absen[$session_absen[$j]]['keterangan'] = $status_absen->status;

				}
				else {					
					$jadwal_absen[$session_absen[$j]]['waktu_absen'] = "belum_absen";
				}
			}
		}		

		if ($jadwal_absen['Pagi']['waktu_absen'] == 'belum_absen'){
			$jadwal_absen['Pagi']['keterangan'] = "Tidak absen";
		}		
		return $jadwal_absen;
	}

	public function jadwal_absen_malam($waktu, $jumat, $current_date, $id_login){
		$jadwal_absen = array();
		$session_absen = array('Pagi', 'Sore');
		for ($j = 0; $j < count($session_absen); $j++){
			$status_absen = DB::table('absens')->select('id', 'waktu', 'status')->where('id_login', $id_login)->where('tanggal', $current_date)->where('status_absen', $session_absen[$j])->first();
			if ($status_absen){
				$jadwal_absen[$session_absen[$j]]['jam_awal'] = "null";
				$jadwal_absen[$session_absen[$j]]['jam_akhir'] = "null";
				$jadwal_absen[$session_absen[$j]]['level'] = "null";
				$jadwal_absen[$session_absen[$j]]['status'] = $status_absen->status;
				$jadwal_absen[$session_absen[$j]]['keterangan'] = "";
				$jadwal_absen[$session_absen[$j]]["is_absen"] = "Tidak";
				$jadwal_absen[$session_absen[$j]]['waktu_absen'] = $status_absen->waktu;
			}
			else {					
				$jadwal_absen[$session_absen[$j]]['jam_awal'] = "null";
				$jadwal_absen[$session_absen[$j]]['jam_akhir'] = "null";
				$jadwal_absen[$session_absen[$j]]['level'] = "null";
				$jadwal_absen[$session_absen[$j]]['status'] = "null";
				$jadwal_absen[$session_absen[$j]]['keterangan'] = "";
				$jadwal_absen[$session_absen[$j]]["is_absen"] = "Tidak";
				$jadwal_absen[$session_absen[$j]]['waktu_absen'] = "Tidak Absen";
			}
		}		
		return $jadwal_absen;		
	}

	public function jadwal_absen_subuh($waktu, $jumat, $current_date, $id_login){
		$jadwal_absen = array();
		$session_absen = array('Pagi', 'Sore');
		for ($j = 0; $j < count($session_absen); $j++){
			$absen = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'status_absen', 'level', 'status')->where('status_absen', $session_absen[$j])->where('jumat', $jumat)->where('status', 'Hadir')->first();		
			$jadwal_absen[$session_absen[$j]]['jam_awal'] = $absen->jam_awal;
			$jadwal_absen[$session_absen[$j]]['jam_akhir'] = $absen->jam_akhir;
			$jadwal_absen[$session_absen[$j]]['level'] = "null";
			$jadwal_absen[$session_absen[$j]]['status'] = "null";
			$jadwal_absen[$session_absen[$j]]['keterangan'] = "subuh";
			$jadwal_absen[$session_absen[$j]]["is_absen"] = "Tidak";
			$jadwal_absen[$session_absen[$j]]['waktu_absen'] = "belum_absen";
		}		
		return $jadwal_absen;		
	}


	public function jadwal_absen(Request $request){
		$user = $request->user();
		$id_login = $user->nip;
		try {
			$timestamp = time(); 
			// check_jumat
			$jumat = $this->check_jumat(date('D', $timestamp)); 
			$waktu = date('H:i:s');
			$current_date = date('Y-m-d'); 			
			$waktu_absen = $this->check_waktu($waktu);	
			$jadwal_absen = array();
			$month = date('m');
			$year = date('Y');
			if ($waktu_absen == "Pagi"){
				$jadwal_absen = $this->jadwal_absen_pagi($waktu, $jumat, $current_date, $id_login);
			}
			else if ($waktu_absen == "Sore"){
				$jadwal_absen = $this->jadwal_absen_sore($waktu, $jumat, $current_date, $id_login);
			}
			else if ($waktu_absen == 'Malam'){
				$jadwal_absen = $this->jadwal_absen_malam($waktu, $jumat, $current_date, $id_login);
			}
			else {
				$jadwal_absen = $this->jadwal_absen_subuh($waktu, $jumat, $current_date, $id_login);
			}

			$query_history = DB::table('absens')->select(DB::raw('day(tanggal) as tanggal'), DB::raw('count(id) as absen'))->where(DB::raw('month(tanggal)'), $month)->where(DB::raw('year(tanggal)'), $year)->groupBy('tanggal')->get();
			$history = array();
			foreach ($query_history as $row){
				$history[$row->tanggal] = $row->absen;
			}
			return response()->json([
				'message' => 'Berhasil',
				'status' => 200,
				'data' => $jadwal_absen,
				'history' => $history
			],200);

		}
		catch (Exception $e){
			return response()->json([
				'message' => 'Internal Error',
				'status' => 200,
				'keterangan' => $e,
			], 500);

		}		
	}

	public function generate_absen(Request $request){
		$tanggal = date('dmY');
		$waktu = date('H:i');
		if ($waktu <= date('H:i', strtotime("12:00"))){
			$status = "Pagi";
		}
		else {
			$status = "Sore";
		}

		$check = Absen_code::where('tanggal', $tanggal)->where('jam_absen', $status)->first();
		if ($check){
			$check->code = $request->code;
			$check->save();
		}
		else {
			$db = new Absen_code;
			$db->code = $request->code;
			$db->tanggal = $tanggal;
			$db->jam_absen = $status;
			$db->save();
		}

		return response()->json([
			'message' => "Data berhasil",
			'status' => 200,
		],200);
	}


	public function check_absen(Request $request){
		$tanggal = date('dmY');
		$waktu = date('H:i');
		$user = $request->user();
		// if ($waktu <= date('H:i', strtotime("12:00"))){
		// 	$status = "Pagi";
		// }
		// else {
		// 	$status = "Sore";
		// }
		$status = $request->status;

		$jumat = date('D', strtotime(date('Y-m-d')));
		if ($jumat == 'Fri'){
			$check_jumat = 'Ya';
		}
		else {
			$check_jumat = "Tidak";
		}

		$status_kehadiran = "";
		$check_kategori = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'level', 'status')->where('status_absen', $status)->where('jumat', $check_jumat)->get();
		foreach ($check_kategori as $row){
			if ($row->keterangan == 'Antara'){
				if (($waktu >= $row->jam_awal) && ($waktu <= $row->jam_akhir)){
					$status_kehadiran = $row->status." ".$row->level;
				}
			}
			else if ($row->keterangan == 'Lebih dari'){
				if ($waktu >= $row->jam_awal){
					$status_kehadiran = $row->status." ".$row->level;
				}						
			}
			else {
				if ($waktu <= $row->jam_awal){
					$status_kehadiran = $row->status." ".$row->level;
				}												
			}
		}
		// ceheck bisa absen atau tidaks
		$hasil = "";
		if ($status_kehadiran == ''){
			$hasil = "Tidak bisa absen";
		}
		else {
			$hasil = "Bisa absen";
		}
		return response()->json([
			'message' => "Data berhasil",
			'status' => 200,
			'code' => $hasil,
		],200);			

	}

	public function verifikasi_kode(Request $request){
		$tanggal = date('dmY');
		$waktu = date('H:i');
		$user = $request->user();
		if ($waktu <= date('H:i', strtotime("12:00"))){
			$status = "Pagi";
		}
		else {
			$status = "Sore";
		}
		$check = DB::table('absen_code')->select('code')->where('tanggal', $tanggal)->where('jam_absen', $status)->first();		
		$echonya = "";
		// // echo $check->code." anjay ".$request->code;
		if ($check->code == $request->code){
			$check_absens = DB::table('absens')->select('id')->where('id_login', $user->nip)->where('tanggal', date('Y-m-d'))->where('status_absen', $status)->first();
			if (!$check_absens){
				$jumat = date('D', strtotime(date('Y-m-d')));
				if ($jumat == 'Fri'){
					$check_jumat = 'Ya';
				}
				else {
					$check_jumat = "Tidak";
				}
				$check_kategori = DB::table('jadwal_absens')->select('jam_awal', 'jam_akhir', 'keterangan', 'level', 'status')->where('status_absen', $status)->where('jumat', $check_jumat)->get();
				$status_kehadiran = "";
				foreach ($check_kategori as $row){
					if ($row->keterangan == 'Antara'){
						if (($waktu >= $row->jam_awal) && ($waktu <= $row->jam_akhir)){
							$status_kehadiran = $row->status." ".$row->level;
						}
					}
					else if ($row->keterangan == 'Lebih dari'){
						if ($waktu >= $row->jam_awal){
							$status_kehadiran = $row->status." ".$row->level;
						}						
					}
					else {
						if ($waktu <= $row->jam_awal){
							$status_kehadiran = $row->status." ".$row->level;
						}												
					}
				}
				if ($status_kehadiran != ""){
					$db = new Absen;
					$db->id_login = $user->nip;
					$db->code = $request->code;
					$db->tanggal = date("Y-m-d");
					$db->waktu = $waktu;
					$db->status = $status_kehadiran;
					$db->status_absen = $status;	
					$db->save();																			
				}
			}
			$echonya = "cocok";
		}
		else {
			$echonya = "tidak_cocok";			
		}


		return response()->json([
			'message' => "Data berhasil",
			'status' => 200,
			'code' => $echonya,
		],200);
	}

}
