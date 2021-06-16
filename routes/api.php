<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ClientSmartAsn\AbsenController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'auth:sanctum'], function(){
	// Absen
	Route::post('/generate_absen', [AbsenController::class, 'generate_absen']);
	Route::post('/absen/check-absen', [AbsenController::class, 'check_absen']);
	Route::post('/absen/verifikasi-kode', [AbsenController::class, 'verifikasi_kode']);
	Route::get('/absen', [AbsenController::class, 'jadwal_absen']);
});