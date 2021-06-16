<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratTugasController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\TugasAsnController;
// use DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
	$opd = DB::table('opd')->select()->first();
	if ($opd){
		return redirect('/login');
	}
	else {
		return redirect('/create-opd');
	}
});

Route::post('/pilih-opd', [AuthController::class, 'pilih_opd']);
Route::get('/create-opd', [AuthController::class, 'create_opd']);
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('post_login', [AuthController::class, 'post_login'])->name('post_login');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


// sura tugas - asn
Route::get('/surat-tugas/{id}/asn', [TugasAsnController::class, 'index']);

// surat tugas - tugas
Route::delete('/surat-tugas/{id}/tugas/delete', [TugasController::class, 'delete']);
Route::post('/surat-tugas/{id}/tugas/update', [TugasController::class, 'update']);
Route::post('/surat-tugas/{id}/tugas/store', [TugasController::class, 'store']);
Route::get('/surat-tugas/{id}/tugas', [TugasController::class, 'index']);
Route::post('/surat-tugas/store', [SuratTugasController::class, 'store']);
Route::get('/surat-tugas', [SuratTugasController::class, 'index']);

Route::group(['middleware'=>'auth'], function(){

    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::group(['middleware'=>'surat'], function(){
        // surat
        Route::get('/surat_masuk', [SuratController::class, 'surat_masuk']);
        Route::get('/surat_keluar', [SuratController::class, 'surat_keluar']);
        Route::post('/post_surat_masuk', [SuratController::class, 'post_surat_masuk'])->name('post_surat_masuk');
        Route::post('/post_surat_keluar', [SuratController::class, 'post_surat_keluar'])->name('post_surat_keluar');
        Route::get('/hapus_surat_keluar/{id}', [SuratController::class, 'hapus_surat_keluar'])->name('hapus_surat_keluar');
        Route::get('/hapus_surat_masuk/{id}', [SuratController::class, 'hapus_surat_masuk'])->name('hapus_surat_masuk');
    });
    
});

