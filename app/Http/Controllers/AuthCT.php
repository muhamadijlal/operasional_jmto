<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginActionR;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthCT extends Controller
{
    public function login()
    {

        return view('auth.login');
    }


    public function loginAction(LoginActionR $request)
    {

        if (Auth::attempt(array(
            'npp_no' => $request->npp,
            'password' => $request->password,
        ))) {

            if (auth()->user()->jabatan_id != '1' || auth()->user()->activated != '1') {
                Auth::logout();
                return back()->with(['error' => 'Jabatan / Aktivasi Akun tidak sesuai'])->withInput($request->all());
            }
            $request->session()->regenerate();



            return redirect('admin/dashboard');
        } else {
            return back()->with(['error' => 'Email / Password yang anda masukan salah'])->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
