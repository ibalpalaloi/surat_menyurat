<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TugasAsn;
use DB;
use File;


class TugasAsnController extends Controller
{
    public function index($id){
    	return view('users/admin/surat_tugas/tugas_asn/index');
    }

    
}
