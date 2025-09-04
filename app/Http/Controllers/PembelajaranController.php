<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran;
use App\Models\Rombonganbelajar;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class PembelajaranController extends Controller
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

    public function show(Request $request, Pembelajaran $pembelajaran)
    {
        //
    }

    public function edit(Pembelajaran $pembelajaran)
    {
        //
    }

    public function update(Request $request, Pembelajaran $pembelajaran)
    {
        //
    }

    public function destroy(Pembelajaran $pembelajaran)
    {
        $rombonganbelajar_id = $pembelajaran->rombonganbelajar_id;
        Pembelajaran::destroy($pembelajaran->id);
        $rombonganbelajar = Rombonganbelajar::where('id', $rombonganbelajar_id)->first();
        echo "Pembelajaran Kelas : ".$rombonganbelajar->nama."<br>";
            echo "Kurikulum : ".$rombonganbelajar->kurikulum->nama_kurikulum;
            $thn = explode("-",$rombonganbelajar->kurikulum->mulai_berlaku);
            $kelompoks = Kelompok::where('kurikulum', $thn[0])->get();
            $pembelajarans = Pembelajaran::where('rombonganbelajar_id', $rombonganbelajar->id)
            ->orderBy('kelompok_id', 'asc')->orderBy('no_urut', 'asc')
            ->get();
            echo '
            <input type="hidden" name="rombonganbelajar_id" value="'.$rombonganbelajar->id.'">
            <table class="table table-bordered table-striped">
                        <thead>
                          <tr>
                            <th class="text-center">No</th>
                            <th class="text-center">Mata Pelajaran Dapodik</th>
                            <th class="text-center">Mata Pelajaran Lokal</th>
                            <th class="text-center">Guru Pengampu</th>
                            <th class="text-center">Kelompok Mapel</th>
                            <th class="text-center">Nomor Urut</th>
                            <th class="text-center">Aksi</th>
                          </tr>
                        </thead>
                        <tbody>';
            $no = 1;
            foreach ($pembelajarans as $pem){
            echo '
                            <tr>
                              <td class="text-center">' . $no++ . '</td>
                              <td>' . $pem->matapelajaran->nama . '</td>
                              <td><input type="text" name="nama'.$pem->id.'" class="form-control" value="'.$pem->nama_mata_pelajaran.'"></td>
                              <td>' . $pem->ptk->nama . '</td>
                              <td>
                              <select name="kel'.$pem->id.'" class="form-control">
                                <option value="">Pilih Kelompok</option>';
                            foreach($kelompoks as $kel){
                              if($kel->id == $pem->kelompok_id){
                                $sel="selected";
                              } else {
                                $sel="";
                              }
                            echo '<option value="'.$kel->id.'" '.$sel.'>'.$kel->nama_kelompok.'</option>';
                            }
                              echo '
                              </select>
                              </td>
                              <td><input type="number" name="urut'.$pem->id.'" class="form-control" value="'.$pem->no_urut.'"></td>
                              <td><a class="btn btn-danger btn-sm" href="javascript:void(0)" data-id="'.$pem->id.'" id="btn-hapus-pembelajaran">Hapus</a></td>
                            </tr>';
            }
            echo '
                    </tbody>
                  </table>';
    }

}
