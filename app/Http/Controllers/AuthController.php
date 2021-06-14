<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;

class AuthController extends Controller
{
    //
    public function login(){
        return view('auth.login');
    }

    public function post_login(Request $request){
        Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ])->validate();

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password])){
            return redirect()->route('dashboard');
        }else{
            return back();
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }
}
