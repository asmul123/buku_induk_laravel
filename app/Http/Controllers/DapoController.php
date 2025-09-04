<?php

namespace App\Http\Controllers;

use App\Models\Dapodik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DapoController extends Controller
{
    
    public function index()
    {
        $dapodik = Dapodik::where('id', '1')->first();
        // $sekolah = Http::withHeaders([
        //     'Authorization' => 'Bearer '.$dapodik->token,
        //     ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
        //         'npsn' => '20209201'
        //     ]);
        
        // $pendidik = Http::withHeaders([
        //     'Authorization' => 'Bearer '.$dapodik->token,
        //     ])->get("http://".$dapodik->address.":5774/WebService/getGtk", [
        //     'npsn' => '20209201'
        //     ]);

        // $rombongan_belajar = Http::withHeaders([
        //     'Authorization' => 'Bearer '.$dapodik->token,
        //     ])->get("http://".$dapodik->address.":5774/WebService/getRombonganBelajar", [
        //     'npsn' => '20209201'
        //     ]);
        
        // $peserta_didik = Http::withHeaders([
        //     'Authorization' => 'Bearer '.$dapodik->token,
        //     ])->get("http://".$dapodik->address.":5774/WebService/getPesertaDidik", [
        //     'npsn' => '20209201'
        //     ]);

        // $pd = $peserta_didik->json();
        // $pdcount = count($pd['rows']);
        // $ptk = $pendidik->json();
        // $gurucount = array_count_values(array_column($ptk['rows'], 'jenis_ptk_id'))['92'];
        // $tucount = array_count_values(array_column($ptk['rows'], 'jenis_ptk_id'))['93'];
        // $rombel = $rombongan_belajar->json();
        // $rombelcount = array_count_values(array_column($rombel['rows'], 'jenis_rombel'))['1'];

        // Ambil hanya bagian "rows" yang berisi array data siswa
        // 'pdcount' => $pdcount,
        // 'gurucount' => $gurucount,
        // 'tucount' => $tucount,
        // 'rombelcount' => $rombelcount
        $data = [
            'menu' => 'pengaturan',
            'smenu' => 'dapodik',
            'dapodik' => $dapodik
        ];
        return view('dapodik', $data);
        // foreach($data as $d){
        //     echo $d['rombongan_belajar_id']." - ".$d['nama']."<br>";
        // }
        // dd($data);
    }

    public function update(Request $request) {
            $validated = $request->validate([
                'address' => 'required',
                'npsn' => 'required',
                'token' => 'required'
            ]);
                    Dapodik::where('id', '1')->update($validated);
                    return redirect()->back()->with('success', 'Berhasil mengubah Pengaturan Dapodik');
            
    }

}
