<?php

namespace App\Http\Controllers;

use App\Models\Rombonganbelajar;
use App\Models\Anggotarombel;
use Illuminate\Http\Request;

class AnggotarombelController extends Controller
{
  
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Request $request, Anggotarombel $anggotarombel)
    {
        //
    }

    public function edit(Anggotarombel $anggotarombel)
    {
        //
    }

    public function update(Request $request, Anggotarombel $anggotarombel)
    {
        //
    }

    public function destroy(Anggotarombel $anggotarombel)
    {
        $rombonganbelajar_id = $anggotarombel->rombonganbelajar_id;
        $rombonganbelajar = Rombonganbelajar::where('id', $rombonganbelajar_id)->first();
        Anggotarombel::destroy($anggotarombel->id);
        $anggotarombels = Anggotarombel::join('pesertadidiks', 'pesertadidiks.id', '=', 'anggotarombels.pesertadidik_id')
                ->where('rombonganbelajar_id',  $rombonganbelajar_id)
                ->orderBy('pesertadidiks.nama', 'asc')
                ->select(
                    'anggotarombels.id as anggotarombel_id',
                    'pesertadidiks.id as pesertadidik_id',
                    'pesertadidiks.*',
                    'anggotarombels.*'
                )
                ->get();
            echo 'Kelas : '.$rombonganbelajar->nama;
            echo '
            <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Nama Murid</th>
                            <th class="text-center">Jenis Kelamin</th>
                            <th class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>';
            $no = 1;
            foreach ($anggotarombels as $ar) :
                echo '
                            <tr>
                              <td class="text-center">' . $no++ . '</td>
                              <td>' . $ar->nama . '</td>
                              <td>' . $ar->jenis_kelamin . '</td>
                              <td><a class="btn btn-danger btn-sm" href="javascript:void(0)" data-id="'.$ar->anggotarombel_id.'" id="btn-hapus-anggota">Keluarkan</a></td>
                            </tr>';
            endforeach;
            echo '
                        </tbody>
                      </table>';
    }

}
