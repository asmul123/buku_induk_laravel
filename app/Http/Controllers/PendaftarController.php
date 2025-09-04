<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\User;
use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftar = Pendaftar::where('nomor_pendaftaran', auth()->user()->nomor_pendaftaran)->first();
        return view('pendaftar', [
            'menu' => 'dashboard',
            'pendaftar' => $pendaftar
        ]);
    }

    public function rekap()
    {
        $pendaftars = Pendaftar::all();
        return view('admin.rekap', [
            'menu' => 'dashboard',
            'pendaftars' => $pendaftars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(request('act')=='hapus'){
            $namafile = File::where('id',request('id'))->where('user_id',auth()->user()->id)->first()->file;
            File::where('id', request('id'))->delete();
            Storage::disk('public')->delete($namafile);            
            return redirect()->route('pendaftar.index')->with('success', 'File berhasil dihapus');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Simpan file ke storage/app/public/uploads
        $filePath = $request->file('file')->store('uploads', 'public');

        $data = ([
            'user_id' => auth()->user()->id,
            'jenis_file' => $request->jenis_file,
            'file' => $filePath
        ]);
                File::create($data);
        // Jika kamu ingin simpan ke database, bisa simpan $filePath di kolom tabel

        return redirect()->route('pendaftar.index')->with('success', 'File berhasil diupload: ' . $filePath);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftar $pendaftar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftar $pendaftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendaftar $pendaftar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendaftar $pendaftar)
    {
        //
    }
}
