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
use App\Models\Absensi;
use App\Models\Kenaikan;
use App\Models\Matapelajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
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

    public function indukmurid(Request $request)
    {
        // Ambil daftar tahun ajaran yang unik dari semester (untuk angkatan)
        $angkatans = Semester::select('tahunajaran_id')
            ->distinct()
            ->orderBy('tahunajaran_id', 'desc')
            ->get();

        $angkatan_id = $request->angkatan_id ?? "";
        $pesertadidiks = "";

        if($angkatan_id != ""){
            // Ambil semester ganjil dari tahun ajaran yang dipilih (semester masuk)
            $semester_masuk = Semester::where('tahunajaran_id', $angkatan_id)
                ->where('semester', 1)
                ->first();
            
            if($semester_masuk){
                // Ambil peserta didik yang pertama kali terdaftar di semester tersebut
                // dengan mengambil yang memiliki rombel kelas 10 di tahun ajaran tersebut
                $pesertadidiks = Pesertadidik::select('pesertadidiks.*')
                    ->join('anggotarombels', 'pesertadidiks.id', '=', 'anggotarombels.pesertadidik_id')
                    ->join('rombonganbelajars', 'anggotarombels.rombonganbelajar_id', '=', 'rombonganbelajars.id')
                    ->join('semesters', 'anggotarombels.semester_id', '=', 'semesters.id')
                    ->where('semesters.tahunajaran_id', $angkatan_id)
                    ->where('semesters.semester', 1) // Semester ganjil
                    ->where('rombonganbelajars.jenisrombel_id', 1) // Rombel reguler
                    ->where('rombonganbelajars.tingkat', 10) // Kelas 10 (asumsi SMA)
                    ->distinct()
                    ->orderBy('pesertadidiks.no_induk', 'asc')
                    ->get();
                
                // Jika tidak ada data kelas 10, coba ambil semua siswa dari tahun ajaran tersebut
                if($pesertadidiks->count() == 0){
                    $pesertadidiks = Pesertadidik::select('pesertadidiks.*')
                        ->join('anggotarombels', 'pesertadidiks.id', '=', 'anggotarombels.pesertadidik_id')
                        ->join('semesters', 'anggotarombels.semester_id', '=', 'semesters.id')
                        ->where('semesters.tahunajaran_id', $angkatan_id)
                        ->where('semesters.semester', 1)
                        ->distinct()
                        ->orderBy('pesertadidiks.no_induk', 'asc')
                        ->get();
                }
            }
        }

        $data = [
            'menu' => 'bukuinduk',
            'smenu' => 'indukmurid',
            'no' => 1,
            'angkatans' => $angkatans,
            'angkatan_id' => $angkatan_id,
            'pesertadidiks' => $pesertadidiks
        ];
        return view('indukmurid', $data);
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
                <td valign="top">No. Induk / NISN </td>
                <td valign="top">:</td>
                <td valign="top">
                    <div class="input-group">
                        <input type="text" class="form-control" name="no_induk" value="'.$murid->no_induk.'" placeholder="No. Induk">
                        <input type="text" class="form-control" name="nisn" value="'.$murid->nisn.'" placeholder="NISN">
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">3.</td>
                <td valign="top">NIK </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="nik" value="'.$murid->nik.'"></td>
            </tr>
            <tr>
                <td valign="top">4.</td>
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
                <td valign="top">5.</td>
                <td valign="top">Tempat, Tanggal Lahir </td>
                <td valign="top">:</td>
                <td valign="top"><div class="input-group">
                <input type="text" class="form-control" name="tempat_lahir" value="'.$murid->tempat_lahir.'">
                <input type="date" class="form-control" name="tanggal_lahir" value="'.$murid->tanggal_lahir.'">
                </div>
                </td>
            </tr>
            <tr>
                <td valign="top">6.</td>
                <td valign="top">Warga Negara </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="warga_negara" value="'.$murid->warga_negara.'" placeholder="Indonesia"></td>
            </tr>
            <tr>
                <td valign="top">7.</td>
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
                <td valign="top">8.</td>
                <td valign="top">Anak Ke </td>
                <td valign="top">:</td>
                <td valign="top"><input type="number" class="form-control" name="anak_ke" value="'.$murid->anak_ke.'" min="1"></td>
            </tr>
            <tr>
                <td valign="top">9.</td>
                <td valign="top">Alamat/tempat tinggal</td>
                <td valign="top">:</td>
                <td valign="top"><textarea class="form-control" name="alamat">'.$murid->alamat.'</textarea>
                    <div class="input-group">
                        <span class="input-group-text">RT</span>
                        <input type="text" name="rt" class="form-control" value="'.$murid->rt.'">
                        <span class="input-group-text">RW</span>
                        <input type="text" name="rw" class="form-control" value="'.$murid->rw.'">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Ds./Kel</span>
                        <input type="text" name="desa_kelurahan" class="form-control" value="'.$murid->desa_kelurahan.'">
                    </div>
                    <div class="input-group">
                        <span class="input-group-text">Kec.</span>
                        <input type="text" name="kecamatan" class="form-control" value="'.$murid->kecamatan.'">
                        <span class="input-group-text">Kode Pos</span>
                        <input type="text" name="kode_pos" class="form-control" value="'.$murid->kode_pos.'">
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">10.</td>
                <td valign="top">No. Telp / Email </td>
                <td valign="top">:</td>
                <td valign="top">
                    <div class="input-group">
                        <input type="text" class="form-control" name="no_telp" value="'.$murid->no_telp.'" placeholder="No. Telp">
                        <input type="email" class="form-control" name="email" value="'.$murid->email.'" placeholder="Email">
                    </div>
                </td>
            </tr>
            <tr>
                <td valign="top">11.</td>
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
                <td valign="top">12.</td>
                <td valign="top">Pekerjaan </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Ayah</td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="kerja_ayah" class="form-control">
                    <option value="">-- Pilih Pekerjaan --</option>';
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
                <select name="kerja_ibu" class="form-control">
                    <option value="">-- Pilih Pekerjaan --</option>';
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
                <td valign="top">13.</td>
                <td valign="top">Nama Wali Siswa </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="nama_wali" value="'.$murid->nama_wali.'"></td>
            </tr>
            <tr>
                <td valign="top">14.</td>
                <td valign="top">Pekerjaan Wali </td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="kerja_wali" class="form-control">
                    <option value="">-- Pilih Pekerjaan --</option>';
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
                <td valign="top">15.</td>
                <td valign="top">Alamat/Telp Wali </td>
                <td valign="top">:</td>
                <td valign="top">
                    <input type="text" class="form-control mb-1" name="alamat_wali" value="'.$murid->alamat_wali.'" placeholder="Alamat Wali">
                    <input type="text" class="form-control" name="telp_wali" value="'.$murid->telp_wali.'" placeholder="Telp Wali">
                </td>
            </tr>
            <tr>
                <td valign="top">16.</td>
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
                <td valign="top"></td>
                <td valign="top">d. No. Ijazah </td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="ijazah_smp" value="'.$murid->ijazah_smp.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">e. Tanggal Ijazah </td>
                <td valign="top">:</td>
                <td valign="top"><input type="date" class="form-control" name="tanggal_ijazah_smp" value="'.$murid->tanggal_ijazah_smp.'"></td>
            </tr>
            <tr>
                <td valign="top">17.</td>
                <td valign="top">Meninggalkan Sekolah </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Tanggal</td>
                <td valign="top">:</td>
                <td valign="top"><input type="date" class="form-control" name="tanggal_meninggalkan" value="'.$murid->tanggal_meninggalkan.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Alasan</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="alasan_meninggalkan" value="'.$murid->alasan_meninggalkan.'"></td>
            </tr>
            <tr>
                <td valign="top">18.</td>
                <td valign="top">Tamat </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. No. Ijazah</td>
                <td valign="top">:</td>
                <td valign="top"><input type="text" class="form-control" name="no_ijazah_akhir" value="'.$murid->no_ijazah_akhir.'"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Tanggal</td>
                <td valign="top">:</td>
                <td valign="top"><input type="date" class="form-control" name="tanggal_ijazah_akhir" value="'.$murid->tanggal_ijazah_akhir.'"></td>
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
                'no_induk' => $request->no_induk,
                'nisn' => $request->nisn,
                'nik' => $request->nik,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'warga_negara' => $request->warga_negara,
                'agama_id' => $request->agama_id,
                'anak_ke' => $request->anak_ke,
                'alamat' => $request->alamat,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'desa_kelurahan' => $request->desa_kelurahan,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'no_telp' => $request->no_telp,
                'email' => $request->email,
                'sekolah_asal' => $request->sekolah_asal,
                'ijazah_smp' => $request->ijazah_smp,
                'tanggal_ijazah_smp' => $request->tanggal_ijazah_smp,
                'diterima_kelas' => $request->diterima_kelas,
                'diterima' => $request->diterima,
                'tanggal_meninggalkan' => $request->tanggal_meninggalkan,
                'alasan_meninggalkan' => $request->alasan_meninggalkan,
                'no_ijazah_akhir' => $request->no_ijazah_akhir,
                'tanggal_ijazah_akhir' => $request->tanggal_ijazah_akhir,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'kerja_ayah' => $request->kerja_ayah,
                'kerja_ibu' => $request->kerja_ibu,
                'nama_wali' => $request->nama_wali,
                'alamat_wali' => $request->alamat_wali,
                'telp_wali' => $request->telp_wali,
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
                        Nilaiakhir::where('id', $ceknilai->first()->id)->update($data);
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
                    $ceknilai = Nilaiakhir::where('pembelajaran_id', $pembelajaranmp->id)->where('anggotarombel_id', $rombelmp->id);
                    if($ceknilai->count() == 0 and $nilai <> 0){
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaranmp->id,
                            'anggotarombel_id' => $rombelmp->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::create($data);
                    } else if($ceknilai->count() >= 1) {
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'pembelajaran_id' => $pembelajaranmp->id,
                            'anggotarombel_id' => $rombelmp->id,
                            'kompetensi_id' => '4',
                            'nilai' => $nilai
                        ];
                        Nilaiakhir::where('id', $ceknilai->first()->id)->update($data);
                    }
                }
            }
        }
    }

    public function editAbsensi(Request $request)
    {
        $anggotarombel_id = $request->anggotarombel_id;
        
        $absensi = Absensi::where('anggotarombel_id', $anggotarombel_id)->first();
        $anggotarombel = Anggotarombel::where('id', $anggotarombel_id)->first();
        $semester = $anggotarombel ? $anggotarombel->semester : null;
        
        echo '
        <input type="hidden" name="anggotarombel_id" value="'.$anggotarombel_id.'">
        <div class="form-group">
            <label>Semester: '.($semester ? $semester->nama : '-').'</label>
            <label>Kelas: '.($anggotarombel && $anggotarombel->rombonganbelajar ? $anggotarombel->rombonganbelajar->nama : '-').'</label>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="sakit">Sakit</label>
                    <input type="number" class="form-control" name="sakit" id="sakit" min="0" value="'.($absensi ? $absensi->sakit : 0).'">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="izin">Izin</label>
                    <input type="number" class="form-control" name="izin" id="izin" min="0" value="'.($absensi ? $absensi->izin : 0).'">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="alpa">Alfa</label>
                    <input type="number" class="form-control" name="alpa" id="alpa" min="0" value="'.($absensi ? $absensi->alpa : 0).'">
                </div>
            </div>
        </div>';
    }

    public function simpanAbsensi(Request $request)
    {
        $sekolah_id = Sekolah::value('id');
        $anggotarombel_id = $request->anggotarombel_id;
        
        $cekAbsensi = Absensi::where('anggotarombel_id', $anggotarombel_id);
        
        $data = [
            'sekolah_id' => $sekolah_id,
            'anggotarombel_id' => $anggotarombel_id,
            'sakit' => $request->sakit ?? 0,
            'izin' => $request->izin ?? 0,
            'alpa' => $request->alpa ?? 0
        ];
        
        if($cekAbsensi->count() == 0) {
            $data['id'] = (string) Str::uuid();
            Absensi::create($data);
        } else {
            Absensi::where('anggotarombel_id', $anggotarombel_id)->update($data);
        }
        
        return response()->json(['success' => true, 'message' => 'Kehadiran berhasil disimpan']);
    }

    public function editKenaikan(Request $request)
    {
        $anggotarombel_id = $request->anggotarombel_id;
        
        $kenaikan = Kenaikan::where('anggotarombel_id', $anggotarombel_id)->first();
        $anggotarombel = Anggotarombel::where('id', $anggotarombel_id)->first();
        $semester = $anggotarombel ? $anggotarombel->semester : null;
        $tingkat = $anggotarombel && $anggotarombel->rombonganbelajar ? $anggotarombel->rombonganbelajar->tingkat : null;
        $isSemesterGenap = $semester ? (int)substr($semester->id, -1) % 2 == 0 : false;
        $isKelulusan = $tingkat == 12 && $isSemesterGenap;
        
        echo '
        <input type="hidden" name="anggotarombel_id" value="'.$anggotarombel_id.'">
        <div class="form-group">
            <label>Semester: '.($semester ? $semester->nama : '-').'</label>
            <label>Kelas: '.($anggotarombel && $anggotarombel->rombonganbelajar ? $anggotarombel->rombonganbelajar->nama : '-').'</label>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="">-- Pilih Status --</option>';
                
                if($isKelulusan) {
                    echo '<option value="3" '.($kenaikan && $kenaikan->status == 3 ? 'selected' : '').'>Lulus</option>';
                    echo '<option value="4" '.($kenaikan && $kenaikan->status == 4 ? 'selected' : '').'>Tidak Lulus</option>';
                } else {
                    echo '<option value="1" '.($kenaikan && $kenaikan->status == 1 ? 'selected' : '').'>Naik Kelas</option>';
                    echo '<option value="2" '.($kenaikan && $kenaikan->status == 2 ? 'selected' : '').'>Tidak Naik Kelas</option>';
                }
                
            echo '</select>
        </div>';
            
            if(!$isKelulusan) {
                echo '
        <div class="form-group">
            <label for="nama_kelas">Nama Kelas Tujuan</label>
            <input type="text" class="form-control" name="nama_kelas" id="nama_kelas" placeholder="Contoh: XII PERHOTELAN 1" value="'.($kenaikan ? $kenaikan->nama_kelas : '').'">
        </div>';
            }
    }

    public function simpanKenaikan(Request $request)
    {
        $sekolah_id = Sekolah::value('id');
        $anggotarombel_id = $request->anggotarombel_id;
        $anggotarombel = Anggotarombel::where('id', $anggotarombel_id)->first();
        $rombonganbelajar_id = $anggotarombel ? $anggotarombel->rombonganbelajar_id : null;
        $tingkat = $anggotarombel && $anggotarombel->rombonganbelajar ? $anggotarombel->rombonganbelajar->tingkat : null;
        $semester = $anggotarombel ? $anggotarombel->semester : null;
        $isSemesterGenap = $semester ? (int)substr($semester->id, -1) % 2 == 0 : false;
        $isKelulusan = $tingkat == 12 && $isSemesterGenap;
        
        $cekKenaikan = Kenaikan::where('anggotarombel_id', $anggotarombel_id);
        
        $data = [
            'sekolah_id' => $sekolah_id,
            'anggotarombel_id' => $anggotarombel_id,
            'rombonganbelajar_id' => $rombonganbelajar_id,
            'status' => $request->status,
            'nama_kelas' => $isKelulusan ? null : ($request->nama_kelas ?? null)
        ];
        
        if($cekKenaikan->count() == 0) {
            $data['id'] = (string) Str::uuid();
            Kenaikan::create($data);
        } else {
            Kenaikan::where('anggotarombel_id', $anggotarombel_id)->update($data);
        }
        
        return response()->json(['success' => true, 'message' => 'Status kenaikan/kelulusan berhasil disimpan']);
    }

    public function getKelompok(Request $request)
    {
        $rombonganbelajar = Rombonganbelajar::where('id', $request->rombonganbelajar_id)->first();
        $thn_kurikulum = date('Y', strtotime($rombonganbelajar->kurikulum->mulai_berlaku));
        $kelompoks = Kelompok::where('kurikulum', $thn_kurikulum)->get();
        
        return response()->json($kelompoks);
    }

    public function getMatapelajaran(Request $request)
    {
        $matapelajarans = Matapelajaran::orderBy('nama', 'asc')->get();
        
        return response()->json($matapelajarans);
    }

    public function tambahMapel(Request $request)
    {
        $sekolah_id = Sekolah::value('id');
        $rombonganbelajar = Rombonganbelajar::where('id', $request->rombonganbelajar_id)->first();
        
        // Generate unique ID
        $id = (string) Str::uuid();
        
        $data = [
            'id' => $id,
            'sekolah_id' => $sekolah_id,
            'semester_id' => $request->semester_id,
            'rombonganbelajar_id' => $request->rombonganbelajar_id,
            'matapelajaran_id' => $request->matapelajaran_id,
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
            'kelompok_id' => $request->kelompok_id,
            'no_urut' => $request->no_urut,
            'is_dapodik' => 0
        ];
        
        Pembelajaran::create($data);
        
        return response()->json(['success' => true, 'message' => 'Mata pelajaran berhasil ditambahkan']);
    }
   
}
