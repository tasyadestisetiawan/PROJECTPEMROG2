<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::orderBy('updated_at', 'desc')->get();
        return view('backend.v_user.index', [
            'judul' => 'User',
            'sub' => 'Data User',
            'index' => $user
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.v_user.create', [
            'judul' => 'Akun',
            'sub' => 'Tambah Akun',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:8|confirmed',
            'role' => 'required',
            'foto' => '',
            'hp' => 'required|min:10|max:13',
        ]);

        // Validasi password
        $password = $request->input('password');
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';

        if (preg_match($pattern, $password)) {
            $validatedData['password'] = Hash::make($validatedData['password']);
            User::create($validatedData);
            return redirect('/user')->with('success', 'Data berhasil tersimpan');
        } else {
            return redirect()->back()->withErrors(['password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.v_user.edit', [
            'judul' => 'User',
            'sub' => 'Ubah User',
            'edit' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $rules = [
            'nama' => 'required|max:255',
            'role' => 'required',
            'hp' => 'required|min:10|max:13',
        ];

        if ($request->email != $user->email) {
            $rules['email'] = 'required|email|max:255|unique:user,email,' . $id;
        }

        $validatedData = $request->validate($rules);

        // Update password
        if ($request->filled('password')) {
            $password = $request->input('password');
            $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).+$/';
            if (preg_match($pattern, $password)) {
                if ($request->password == $request->password_confirmation) {
                    $validatedData['password'] = Hash::make($password);
                } else {
                    return redirect()->back()->withErrors(['password' => 'Password dan konfirmasi password tidak cocok.']);
                }
            } else {
                return redirect()->back()->withErrors(['password' => 'Password harus terdiri dari kombinasi huruf besar, huruf kecil, angka, dan simbol karakter.']);
            }
        }

        $user->update($validatedData);
        return redirect('/user')->with('success', 'Data berhasil diperbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user->transaksi()->exists()) {
            return redirect('/user')->with('error', 'User tidak dapat dihapus karena sudah terkait dengan transaksi.');
        }
        $user->delete();
        return redirect('/user')->with('msgSuccess', 'Data berhasil dihapus');
    }

    public function profile()
    {
        $user = Auth::user();
        return view('backend.v_profile.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'foto' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $imageName = time() . '.' . $request->foto->extension();
            $request->foto->storeAs('public/fotos', $imageName);
            $user->foto = 'fotos/' . $imageName;
        }

        $user->save();

        return redirect()->route('home')->with('success', 'Update Profil Berhasil');
    }
}
