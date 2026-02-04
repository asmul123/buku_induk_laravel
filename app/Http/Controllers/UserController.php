<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Role;

class UserController extends Controller
{
    public function index()
    {
        return view('administrator.user', [
            'menu' => 'referensi',
            'smenu' => 'user',
            'users' => User::all(),
            'roles' => Role::all()
        ]);
    }

    public function ubahpassword()
    {
        return view('akun', [
            'menu' => 'akun',
            'smenu' => '',
        ]);
    }

    public function passwordupdate(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'confirmed']
        ]);

        $currentPasswordStatus = Hash::check($request->current_password, auth()->user()->password);
        if ($currentPasswordStatus) {

            User::findOrFail(Auth::user()->id)->update([
                'password' => Hash::make($request->password),
            ]);

            return redirect()->back()->with('success', 'Kata Sandi Berhasil diganti');
        } else {
            return redirect()->back()->with('failed', 'Kata sandi saat ini salah');
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::findOrFail(Auth::user()->id);
        
        // Cek jika email sudah digunakan user lain
        $existingUser = User::where('email', $request->email)->where('id', '!=', $user->id)->first();
        if ($existingUser) {
            return redirect()->back()->with('failed', 'Email sudah digunakan oleh pengguna lain');
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->back()->with('success_profile', 'Profil berhasil diperbarui');
    }

    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $user = User::findOrFail(Auth::user()->id);

        // Hapus foto lama jika ada
        if ($user->photo && file_exists(public_path('storage/photos/' . $user->photo))) {
            unlink(public_path('storage/photos/' . $user->photo));
        }

        // Upload foto baru
        $file = $request->file('photo');
        $filename = time() . '_' . Auth::user()->id . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('storage/photos'), $filename);

        $user->update([
            'photo' => $filename,
        ]);

        return redirect()->back()->with('success_photo', 'Foto profil berhasil diperbarui');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role_id' => 'required'
        ]);
        if ($validated['password'] !== $request->password_confirmation) {
            return redirect()->back()->with('failed', 'Konfirmasi Kata Sandi tidak sesuai');
        } else {
            User::create($validated);
            return redirect()->back()->with('success', 'User berhasil disimpan');
        }
    }

    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->back()->with('success', 'User berhasil dihapus');
    }
}
