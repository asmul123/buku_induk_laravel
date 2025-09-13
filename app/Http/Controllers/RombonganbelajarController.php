<?php

namespace App\Http\Controllers;

use App\Models\Rombonganbelajar;
use App\Models\Semester;
use App\Models\Anggotarombel;
use App\Models\Pembelajaran;
use App\Models\Kelompok;
use Illuminate\Http\Request;

class RombonganbelajarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {      
      $tapels = Semester::orderBy('id', 'desc')->get();
      $semester_aktif = Semester::where('periode_aktif', '1')->first()->id;
      if($request->sem_id) {
        $semester_aktif = $request->sem_id;
      }
        $rombonganbelajars = Rombonganbelajar::where('semester_id', $semester_aktif)->orderBy('jenisrombel_id', 'asc')->orderBy('nama', 'asc')->get();
        $data = [
            'menu' => 'referensi',
            'smenu' => 'rombonganbelajar',
            'tapels' => $tapels,
            'sem_id' => $semester_aktif,
            'no' => 0,
            'rombonganbelajars' => $rombonganbelajars
        ];
        return view('rombel', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rombonganbelajar = Rombonganbelajar::where('id', $request->rombonganbelajar_id)->first();
        $pembelajarans = Pembelajaran::where('rombonganbelajar_id', $rombonganbelajar->id)
            ->orderBy('kelompok_id', 'asc')->orderBy('no_urut', 'asc')
            ->get();
        foreach ($pembelajarans as $pem){
          if($request->{'kel'.$pem->id} != ""){
            $data = [
              'nama_mata_pelajaran' => $request->{'nama'.$pem->id},
              'kelompok_id' => $request->{'kel'.$pem->id},
              'no_urut' => $request->{'urut'.$pem->id}
            ];
            Pembelajaran::where('id', $pem->id)->update($data);
          }
        }
        $this->pembelajaranshow($rombonganbelajar->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Rombonganbelajar $rombonganbelajar)
    {
        if($request->aksi == "anggota"){
            $anggotarombels = Anggotarombel::join('pesertadidiks', 'pesertadidiks.id', '=', 'anggotarombels.pesertadidik_id')
                ->where('rombonganbelajar_id',  $rombonganbelajar->id)
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
        } else if ($request->aksi == "pembelajaran"){
            $this->pembelajaranshow($rombonganbelajar->id);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rombonganbelajar $rombonganbelajar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Rombonganbelajar $rombonganbelajar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rombonganbelajar $rombonganbelajar)
    {
        //
    }

    public function hapuspembelajaran($id)
    {
        $pembelajaran = Pembelajaran::where('id', $id);
        $rombonganbelajar_id = $pembelajaran->first()->rombonganbelajar_id;
        $pembelajaran->delete();
        
        echo "$rombonganbelajar_id";
        $this->pembelajaranshow($rombonganbelajar_id);

    }

    private function pembelajaranshow($rombonganbelajar_id)
    {
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
              if($pem->ptk){
                $pengampu = $pem->ptk->nama;
              } else {
                $pengampu = '-';
              }
            echo '
                            <tr>
                              <td class="text-center">' . $no++ . '</td>
                              <td>' . $pem->matapelajaran->nama . '</td>
                              <td><input type="text" name="nama'.$pem->id.'" class="form-control" value="'.$pem->nama_mata_pelajaran.'"></td>
                              <td>' . $pengampu . '</td>
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
