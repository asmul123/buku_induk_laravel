<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Semester;
use App\Models\Rombonganbelajar;
use App\Models\Anggotarombel;
use App\Models\Pesertadidik;
use App\Models\Agama;
use App\Models\Pekerjaan;
use App\Models\Pembelajaran;
use App\Models\Nilaiakhir;
use App\Models\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function cetak(Request $request)
    {
        $pd_id = $request->pd_id;
        $murid = Pesertadidik::where('id', $pd_id)->first();
        $rombels = Anggotarombel::where('pesertadidik_id', $pd_id)
        ->whereHas('rombonganbelajar', function ($query) {
            $query->where('jenisrombel_id', '1');
        })
        ->orderBy('semester_id','asc')->get();

        $pdf = Pdf::loadView('cetak', compact('murid', 'rombels'))
                  ->setPaper('A3', 'landscape');

        return $pdf->stream('buku_induk - '.$murid->nama.'.pdf');
    }

    public function upload(Request $request)
    {
        // Validasi
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);
            $cekphoto = Pesertadidik::where('id',$request->pesertadidik_id)->first()->photo;
            $cekphoto <> null ? Storage::disk('public')->delete($cekphoto) : false;
        // Simpan file ke storage/app/public/uploads
        $filePath = $request->file('file')->store('uploads', 'public');

        $data = ([
            'photo' => $filePath
        ]);
            Pesertadidik::where('id', $request->pesertadidik_id)->update($data);
        // Jika kamu ingin simpan ke database, bisa simpan $filePath di kolom tabel
        return redirect()->intended('/detailmurid?pd_id='.$request->pesertadidik_id);
    }

    public function edit(Request $request)
    {
        $murid=Pesertadidik::where('id', $request->murid_id)->first();
        
        echo '
        <input type="hidden" class="form-control" name="id" value="'.$murid->id.'">
        <table>
            <tr>
                <td width="5%">1.</td>
                <td width="40%">Nama Lengkap </td>
                <td width="2%">:</td>
                <td width="53%" valign="top"><input type="text" class="form-control" name="nama" value="'.$murid->nama.'"></td>
            </tr>
            <tr>
                <td valign="top">2.</td>
                <td valign="top">Jenis Kelamin </td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="jenis_kelamin" class="form-control">';
                if($murid->jenis_kelamin == 'L'){
                    echo '<option value="L" selected>Laki-laki</option>
                    <option value="P">Perempuan</option>';
                } else {
                    echo '<option value="L">Laki-laki</option>
                    <option value="P" selected>Perempuan</option>';
                }
                echo '</select>
                </td>
            </tr>
            <tr>
                <td valign="top">3.</td>
                <td valign="top">Tempat, Tanggal Lahir </td>
                <td valign="top">:</td>
                <td valign="top"><div class="input-group">
                <input type="text" class="form-control" name="tempat_lahir" value="'.$murid->tempat_lahir.'">
                <input type="date" class="form-control" name="tanggal_lahir" value="'.$murid->tanggal_lahir.'">
                </div>
                </td>
            </tr>
            <tr>
                <td valign="top">4.</td>
                <td valign="top">Warga Negara</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="warga_negara" value="'.$murid->warga_negara.'"></td>
            </tr>
            <tr>
                <td valign="top">5.</td>
                <td valign="top">Agama </td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="agama_id" class="form-control">';
                    $agamas = Agama::all();
                    foreach($agamas as $agama){
                        if($agama->id == $murid->agama_id){
                            $sel = ' selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option value="'.$agama->id.'"'.$sel.'>'.$agama->nama.'</option>';
                    }
                echo '
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top">6.</td>
                <td valign="top">Alamat/tempat tinggal</td>
                <td valign="top">:</td>
                <td valign="top"><textarea class="form-control" name="alamat">'.$murid->alamat.'</textarea>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">RT</span>
                        <input type="text" name="rt" class="form-control" value="'.$murid->rt.'">
                        <span class="input-group-text" id="basic-addon1">RW</span>
                        <input type="text" name="rw" class="form-control" value="'.$murid->rw.'">
                        <span class="input-group-text" id="basic-addon1">Ds./Kel</span>
                        <input type="text" name="desa_kelurahan" class="form-control" value="'.$murid->desa_kelurahan.'">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text" id="basic-addon1">Kec.</span>
                        <input type="text" name="kecamatan" class="form-control" value="'.$murid->kecamatan.'">
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">7.</td>
                <td valign="top">Nama Orang Tua </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Ayah</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="nama_ayah" value="'.$murid->nama_ayah.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Ibu</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="nama_ibu" value="'.$murid->nama_ibu.'"></td>
            </tr>
            <tr>
                <td valign="top">8.</td>
                <td valign="top">Pekerjaan </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Ayah</td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="kerja_ayah" class="form-control">';
                    $pekerjaans = Pekerjaan::all();
                    foreach($pekerjaans as $pekerjaan){
                        if($pekerjaan->id == $murid->kerja_ayah){
                            $sel = ' selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option value="'.$pekerjaan->id.'"'.$sel.'>'.$pekerjaan->nama.'</option>';
                    }
                echo '
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Ibu</td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="kerja_ibu" class="form-control">';
                    $pekerjaans = Pekerjaan::all();
                    foreach($pekerjaans as $pekerjaan){
                        if($pekerjaan->id == $murid->kerja_ibu){
                            $sel = ' selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option value="'.$pekerjaan->id.'"'.$sel.'>'.$pekerjaan->nama.'</option>';
                    }
                echo '
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top">9.</td>
                <td valign="top">Nama Wali Siswa </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="nama_wali" value="'.$murid->nama_wali.'"></td>
            </tr>
            <tr>
                <td valign="top">10.</td>
                <td valign="top">Pekerjaan Wali </td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="kerja_wali" class="form-control">';
                    $pekerjaans = Pekerjaan::all();
                    foreach($pekerjaans as $pekerjaan){
                        if($pekerjaan->id == $murid->kerja_wali){
                            $sel = ' selected';
                        } else {
                            $sel = '';
                        }
                        echo '<option value="'.$pekerjaan->id.'"'.$sel.'>'.$pekerjaan->nama.'</option>';
                    }
                echo '
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top">11.</td>
                <td valign="top">Alamat Rumah Wali </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="alamat_wali" value="'.$murid->alamat_wali.'"></td>
            </tr>
            <tr>
                <td valign="top">12.</td>
                <td valign="top">Diterima Menjadi Siswa </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Di kelas</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="diterima_kelas" value="'.$murid->diterima_kelas.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Mulai tanggal</td>
                <td valign="top">:</td>
                <td valign="top"><input type="date" class="form-control" name="diterima" value="'.$murid->diterima.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">c. Asal Sekolah</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="sekolah_asal" value="'.$murid->sekolah_asal.'"></td>
            </tr>
            <tr>
                <td colspan="4" align="right">                
                    <button type="submit" id="btnSubmit" class="btn btn-primary">
                        <span id="btnText">Simpan</span>
                    </button>
                </td>
            </tr>
        </table>';
    }

    public function editnilai(Request $request)
    {
        $rombel = Anggotarombel::where('id', $request->rombel_id)->first();
        $thn_kurikulum = date('Y', strtotime($rombel->rombonganbelajar->kurikulum->mulai_berlaku));
        $kelompoks = Kelompok::where('kurikulum', $thn_kurikulum)->get();
        echo '
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-responsive-sm">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Mata Pelajaran</th>
                            <th>NA</th>
                        </tr>
                    </thead>
                    <tbody>';
                        foreach($kelompoks as $kelompok){
                            echo '
                            <tr>
                                <th colspan="4">'. $kelompok->nama_kelompok .'</th>                                                            
                            </tr>';
                            $no_urut = 1;
                            $pembelajarans = Pembelajaran::where('rombonganbelajar_id', $rombel->rombonganbelajar_id)->where('kelompok_id', $kelompok->id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                            foreach($pembelajarans as $pembelajaran) {
                            echo '
                            <tr>
                                <td>'. $no_urut++ .'</td>
                                <td>'. $pembelajaran->nama_mata_pelajaran .'</td>                                                                    
                                <td>';
                                    $nilai = Nilaiakhir::where('pembelajaran_id', $pembelajaran->id)->where('anggotarombel_id', $rombel->id)->first();
                                    if($nilai){
                                        $na = $nilai->nilai;
                                    } else {
                                        $na = 0;
                                    }
                                    echo '<input type="number" class="form-control" name="nilai'.$pembelajaran->id.'" value="'.$na.'">
                                    <input type="hidden" name="anggotarombel_id" value="'.$request->rombel_id.'">
                                </td>
                            </tr>';
                            }
                        }
                            $rombelmps = Anggotarombel::where('pesertadidik_id', $rombel->pesertadidik_id)
                            ->whereHas('rombonganbelajar', function ($query) {
                                $query->where('jenisrombel_id', '16');
                            })->where('semester_id', $rombel->semester_id)->get();
                            foreach($rombelmps as $rombelmp) {
                                $pembelajaranmps = Pembelajaran::where('rombonganbelajar_id', $rombelmp->rombonganbelajar_id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                                foreach($pembelajaranmps as $pembelajaranmp) {
                                echo '
                                <tr>
                                    <td>'. $no_urut++ .'</td>
                                    <td>Mapel Pilihan : '. $pembelajaranmp->nama_mata_pelajaran .'</td>                                                                    
                                    <td>';
                                        $nilai = Nilaiakhir::where('pembelajaran_id', $pembelajaranmp->id)->where('anggotarombel_id', $rombelmp->id)->first();
                                        if($nilai){
                                            $na = $nilai->nilai;
                                        } else {
                                            $na = 0;
                                        }
                                    echo '<input type="number" class="form-control" name="nilai'.$pembelajaranmp->id.'" value="'.$na.'">
                                    </td>
                                </tr>';
                                }
                            }
                    echo '
                        <tr>
                            <td colspan="4" align="right">                
                                <button type="submit" id="btnSubmit" class="btn btn-primary">
                                    <span id="btnText">Simpan</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>';
    }
    
    public function updateinduk(Request $request)
    {
        if($request->id){
            $data = [
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'warga_negara' => $request->warga_negara,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama_id' => $request->agama_id,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'sekolah_asal' => $request->sekolah_asal,
                'diterima_kelas' => $request->diterima_kelas,
                'diterima' => $request->diterima,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'kerja_ayah' => $request->kerja_ayah,
                'kerja_ibu' => $request->kerja_ibu,
                'nama_wali' => $request->nama_wali,
                'alamat_wali' => $request->alamat_wali,
                'kerja_wali' => $request->kerja_wali,
            ];
            Pesertadidik::where('id', $request->id)->update($data);
        } else if ($request->anggotarombel_id){
            $rombel = Anggotarombel::where('id', $request->anggotarombel_id)->first();
            $thn_kurikulum = date('Y', strtotime($rombel->rombonganbelajar->kurikulum->mulai_berlaku));
            $kelompoks = Kelompok::where('kurikulum', $thn_kurikulum)->get();
            $sekolah_id = Sekolah::value('id');
            foreach($kelompoks as $kelompok){
                $pembelajarans = Pembelajaran::where('rombonganbelajar_id', $rombel->rombonganbelajar_id)->where('kelompok_id', $kelompok->id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                foreach($pembelajarans as $pembelajaran) {
                    $pemb_id = $pembelajaran->id;
                    $nilai = $request->{'nilai'.$pemb_id};
                    $ceknilai = Nilaiakhir::where('pembelajaran_id', $pembelajaran->id)->where('anggotarombel_id', $rombel->id);
                    if($ceknilai->count() == 0 and $nilai <> 0){
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaran->id,
                            'anggotarombel_id' => $rombel->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::create($data);
                    } else if ($ceknilai->count() >= 1) {
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaran->id,
                            'anggotarombel_id' => $rombel->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::where('id', $ceknilai->first()->id);
                    }
                }
            }
            $rombelmps = Anggotarombel::where('pesertadidik_id', $rombel->pesertadidik_id)
            ->whereHas('rombonganbelajar', function ($query) {
                $query->where('jenisrombel_id', '16');
            })->where('semester_id', $rombel->semester_id)->get();
            foreach($rombelmps as $rombelmp) {
                $pembelajaranmps = Pembelajaran::where('rombonganbelajar_id', $rombelmp->rombonganbelajar_id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                foreach($pembelajaranmps as $pembelajaranmp) {
                    $pemb_id = $pembelajaranmp->id;
                    $nilai = $request->{'nilai'.$pemb_id};
                    $ceknilai = Nilaiakhir::where('pembelajaran_id', $pembelajaranmp->id)->where('anggotarombel_id', $rombel->id);
                    if($ceknilai->count() == 0 and $nilai <> 0){
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaran->id,
                            'anggotarombel_id' => $rombel->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::create($data);
                    } else if($ceknilai->count() >= 1) {
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaran->id,
                            'anggotarombel_id' => $rombel->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::where('id', $ceknilai->first()->id);
                    }
                }
            }
        }
    }
   
}
