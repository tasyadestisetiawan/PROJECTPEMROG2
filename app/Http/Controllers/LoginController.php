<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('backend.v_login.index', [
            'judul' => 'LOGIN',
            'sub' => 'Halaman Login',
        ]);
    }

    public function authenticate(Request $request)
    {
        // dd($request);
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        // dd('login berhasil');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/home');
        }

        return back()->with('msgError', 'Login Gagal');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }    
}
