<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Pendaftar;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function admin()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        // dd($request);
        $cekpendaftar =Pendaftar::where('nomor_pendaftaran', $request->nomor_pendaftaran)->count();
        if ($cekpendaftar >= 1){
            $tanggal_lahir = Pendaftar::where('nomor_pendaftaran', $request->nomor_pendaftaran)->first()->tanggal_lahir;
            if ($tanggal_lahir == $request->tanggal_lahir){
                $credentials = $request->validate([
                    'nomor_pendaftaran' => 'required',
                    'password' => 'required'
                ]);
                
                if (Auth::attempt($credentials)) {
                    $request->session()->regenerate();
                    
                    return redirect()->intended('/pendaftar');
                }                
            } else {
                return redirect()->back()->with('failed', 'Tanggal Lahir Salah');
            }
        } else {
            return redirect()->back()->with('failed', 'Nomor Pendaftaran Salah');
        }
    }

    public function authadmin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);
                
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();                    
            return redirect()->intended('/indukrombel');
        } else {
            return redirect()->back()->with('failed', 'Nama Pengguna atau Kata Sandi Salah');
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
