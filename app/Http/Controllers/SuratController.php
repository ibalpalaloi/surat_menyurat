<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Surat_masuk;
use App\Models\Surat_keluar;
use File;

class SuratController extends Controller
{
    //
    public function surat_masuk(){
        $surat_masuk = Surat_masuk::all();
        return view('surat.surat_masuk', compact('surat_masuk'));
    }

    public function post_surat_masuk(Request $request){
        $surat = new Surat_masuk;
        $surat->nomor_surat = $request->no_surat;
        $surat->tgl_masuk = $request->tgl_masuk;
        $surat->perihal = $request->perihal;
        if($request->hasFile('file')){
            $request->file('file')->move('arsip_surat_masuk/', $request->no_surat.'.pdf');
            $surat->arsip = $request->no_surat.'.pdf';
        }
        $surat->save();
        return back();
    }

    public function surat_keluar(){
        $surat_keluar = Surat_keluar::all();
        return view('surat.surat_keluar', compact('surat_keluar'));
    }

    public function post_surat_keluar(Request $request){
        $surat = new Surat_keluar;
        $surat->nomor_surat = $request->no_surat;
        $surat->tgl_keluar = $request->tgl_keluar;
        $surat->perihal = $request->perihal;
        if($request->hasFile('file')){
            $request->file('file')->move('arsip_surat_keluar/', $request->no_surat.'.pdf');
            $surat->arsip = $request->no_surat.'.pdf';
        }
        $surat->save();
        return back();
    }

    public function hapus_surat_keluar($id){
        $surat = Surat_keluar::find($id);
        File::delete('arsip_surat_keluar/'.$surat->arsip);
        $surat->delete();
        return back();
    }

    public function hapus_surat_masuk($id){
        $surat = Surat_masuk::find($id);
        File::delete('arsip_surat_masuk/'.$surat->arsip);
        $surat->delete();
        return back();
    }
}
