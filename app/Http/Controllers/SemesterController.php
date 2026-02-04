<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderBy('id', 'desc')->paginate(20);
        $semesterAktif = Semester::where('periode_aktif', 1)->first();
        
        $data = [
            'menu' => 'pengaturan',
            'smenu' => 'semester',
            'semesters' => $semesters,
            'semesterAktif' => $semesterAktif
        ];
        
        return view('semester.index', $data);
    }
    
    public function create()
    {
        $data = [
            'menu' => 'pengaturan',
            'smenu' => 'semester'
        ];
        
        return view('semester.create', $data);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|unique:semesters,id',
            'tahunajaran_id' => 'required|numeric',
            'nama' => 'required|string|max:255',
            'semester' => 'required|in:1,2',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ]);
        
        Semester::create([
            'id' => $request->id,
            'tahunajaran_id' => $request->tahunajaran_id,
            'nama' => $request->nama,
            'semester' => $request->semester,
            'periode_aktif' => 0,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);
        
        return redirect('/semester')->with('success', 'Semester berhasil ditambahkan');
    }
    
    public function setAktif($id)
    {
        // Nonaktifkan semua semester
        Semester::where('periode_aktif', 1)->update(['periode_aktif' => 0]);
        
        // Aktifkan semester yang dipilih
        Semester::where('id', $id)->update(['periode_aktif' => 1]);
        
        return redirect('/semester')->with('success', 'Semester aktif berhasil diubah');
    }
    
    public function destroy($id)
    {
        $semester = Semester::findOrFail($id);
        
        if ($semester->periode_aktif == 1) {
            return redirect('/semester')->with('error', 'Tidak dapat menghapus semester yang sedang aktif');
        }
        
        $semester->delete();
        
        return redirect('/semester')->with('success', 'Semester berhasil dihapus');
    }
}
