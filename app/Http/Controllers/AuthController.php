<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Psy\Readline\Hoa\ConsoleOutput;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    //
    public function login()
    {
        if (Session::get('login')) {
            return redirect('dashboard');
        } else {
            return view('login')->with('toast_error', 'Session Timeout, Login Again!');
        }
    }

    public function action(Request $request)
    {

        //$user = User::get();

        Session::flash('nama', $request->nama);
        $request->validate([
            'nama' => ['required'],
            'password' => ['required'],
        ]);

        $infologin = [
            'nama' => $request->nama,
            'password' => $request->password, // Password Harus Hash Laravel
        ];

        if (Auth::attempt($infologin)) {
            if (Auth::user()->bidang == 'listrik') {
                $request->session()->regenerate();
                return redirect('dashboard')->with('toast_success', 'Login Successfully!');
            }

            if (Auth::user()->bidang == 'operasi') {
                return redirect('dashboard')->with('toast_success', 'Login Successfully!');
            }
        }

        return redirect('login')->with('toast_error', 'Login Invalid');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login')->with('toast_success', 'Logout Successfully!');
    }
}
