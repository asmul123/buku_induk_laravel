<?php

namespace App\Http\Controllers;

use App\Models\Pesertadidik;
use App\Models\Semester;
use App\Models\Anggotarombel;
use App\Models\Nilaiakhir;
use App\Models\Sekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semester aktif
        $semesterAktif = Semester::where('periode_aktif', 1)->first();
        
        // Jumlah siswa aktif (yang terdaftar di anggota rombel pada semester ini)
        $jumlahSiswaAktif = 0;
        if ($semesterAktif) {
            $jumlahSiswaAktif = Anggotarombel::where('semester_id', $semesterAktif->id)
                ->whereHas('rombonganbelajar', function ($query) {
                    $query->where('jenisrombel_id', '1');
                })
                ->distinct('pesertadidik_id')
                ->count('pesertadidik_id');
        }
        
        // Jumlah siswa laki-laki aktif
        $jumlahSiswaLaki = 0;
        if ($semesterAktif) {
            $jumlahSiswaLaki = Anggotarombel::where('semester_id', $semesterAktif->id)
                ->whereHas('rombonganbelajar', function ($query) {
                    $query->where('jenisrombel_id', '1');
                })
                ->whereHas('pesertadidik', function ($query) {
                    $query->where('jenis_kelamin', 'L');
                })
                ->distinct('pesertadidik_id')
                ->count('pesertadidik_id');
        }
        
        // Jumlah siswa perempuan aktif
        $jumlahSiswaPerempuan = $jumlahSiswaAktif - $jumlahSiswaLaki;
        
        // Jumlah nilai yang sudah diinput pada semester ini
        $jumlahNilaiInput = 0;
        if ($semesterAktif) {
            $jumlahNilaiInput = Nilaiakhir::whereHas('anggotarombel', function ($query) use ($semesterAktif) {
                $query->where('semester_id', $semesterAktif->id);
            })->count();
        }
        
        // Total peserta didik (semua)
        $totalPesertaDidik = Pesertadidik::count();
        
        // Jumlah rombel aktif
        $jumlahRombelAktif = 0;
        if ($semesterAktif) {
            $jumlahRombelAktif = \App\Models\Rombonganbelajar::where('semester_id', $semesterAktif->id)
                ->where('jenisrombel_id', '1')
                ->count();
        }
        
        // Data untuk grafik perkembangan jumlah siswa per tahun pelajaran
        $chartData = $this->getChartData();
        
        $sekolah = Sekolah::first();
        
        $data = [
            'menu' => 'dashboard',
            'smenu' => '',
            'semesterAktif' => $semesterAktif,
            'jumlahSiswaAktif' => $jumlahSiswaAktif,
            'jumlahSiswaLaki' => $jumlahSiswaLaki,
            'jumlahSiswaPerempuan' => $jumlahSiswaPerempuan,
            'jumlahNilaiInput' => $jumlahNilaiInput,
            'totalPesertaDidik' => $totalPesertaDidik,
            'jumlahRombelAktif' => $jumlahRombelAktif,
            'chartLabels' => $chartData['labels'],
            'chartValues' => $chartData['values'],
            'sekolah' => $sekolah
        ];
        
        return view('dashboard', $data);
    }
    
    private function getChartData()
    {
        // Ambil data jumlah siswa per tahun ajaran (dari semester ganjil saja untuk menghindari duplikat)
        $data = DB::table('anggotarombels')
            ->join('semesters', 'anggotarombels.semester_id', '=', 'semesters.id')
            ->join('rombonganbelajars', 'anggotarombels.rombonganbelajar_id', '=', 'rombonganbelajars.id')
            ->where('rombonganbelajars.jenisrombel_id', '1')
            ->where('semesters.semester', '1') // Hanya semester ganjil
            ->select(
                'semesters.tahunajaran_id',
                DB::raw('COUNT(DISTINCT anggotarombels.pesertadidik_id) as jumlah_siswa')
            )
            ->groupBy('semesters.tahunajaran_id')
            ->orderBy('semesters.tahunajaran_id', 'asc')
            ->get();
        
        $labels = [];
        $values = [];
        
        foreach ($data as $row) {
            $tahun = $row->tahunajaran_id;
            $labels[] = $tahun . '/' . ($tahun + 1);
            $values[] = $row->jumlah_siswa;
        }
        
        // Ambil 10 tahun terakhir saja jika data terlalu banyak
        if (count($labels) > 10) {
            $labels = array_slice($labels, -10);
            $values = array_slice($values, -10);
        }
        
        return [
            'labels' => $labels,
            'values' => $values
        ];
    }
}
