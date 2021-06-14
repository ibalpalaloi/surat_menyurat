<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SuratController;

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
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('post_login', [AuthController::class, 'post_login'])->name('post_login');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

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

