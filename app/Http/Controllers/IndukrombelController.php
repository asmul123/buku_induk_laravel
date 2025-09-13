<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Rombonganbelajar;
use App\Models\Anggotarombel;
use App\Models\Pesertadidik;
use Illuminate\Http\Request;

class IndukrombelController extends Controller
{
    public function index(Request $request)
    {
        if($request->sem_id){
            $sem_id = $request->sem_id;
            $rombels = Rombonganbelajar::where('semester_id', $sem_id)->where('jenisrombel_id', 1)->orderBy('nama', 'asc')->get();
        } else {
            $sem_id = "";
            $rombels ="";
        }

        if($request->rom_id){
            $rom_id = $request->rom_id;
            $anggotarombels = Anggotarombel::join('pesertadidiks', 'pesertadidiks.id', '=', 'anggotarombels.pesertadidik_id')
                ->where('rombonganbelajar_id',  $rom_id)
                ->orderBy('pesertadidiks.nama', 'asc')
                ->select(
                    'anggotarombels.id as anggotarombel_id',
                    'pesertadidiks.id as pesertadidik_id',
                    'pesertadidiks.*',
                    'anggotarombels.*'
                )
                ->get();
        } else {
            $rom_id = "";
            $anggotarombels ="";
        }
        $tapels = Semester::orderBy('id', 'desc')->get();
        $rombonganbelajars = Rombonganbelajar::orderBy('jenisrombel_id', 'asc')->orderBy('nama', 'asc')->get();
        $data = [
            'menu' => 'bukuinduk',
            'smenu' => 'indukrombel',
            'no' => 1,
            'rombonganbelajars' => $rombonganbelajars,
            'tapels' => $tapels,
            'sem_id' => $sem_id,
            'rom_id' => $rom_id,
            'rombels' => $rombels,
            'anggotarombels' => $anggotarombels
        ];
        return view('indukrombel', $data);
    }

    public function detail(Request $request)
    {
        $pd_id = $request->pd_id;
        $murid = Pesertadidik::where('id', $pd_id)->first();
        $rombels = Anggotarombel::where('pesertadidik_id', $pd_id)
        ->whereHas('rombonganbelajar', function ($query) {
            $query->where('jenisrombel_id', '1');
        })
        ->orderBy('semester_id','asc')->get();
        $data = [
            'menu' => 'bukuinduk',
            'smenu' => 'detail',
            'murid' => $murid,
            'rombels' => $rombels,
            'no' => 1
        ];
        return view('detailmurid', $data);
    }
}
