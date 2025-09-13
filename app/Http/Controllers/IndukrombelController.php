<?php

namespace App\Http\Controllers;

use App\Models\Semester;
use App\Models\Rombonganbelajar;
use App\Models\Anggotarombel;
use App\Models\Pesertadidik;
use App\Models\Agama;
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
                <td valign="top"><input type="text" class="form-control" name="warga_negera" value="'.$murid->warga_negera.'"></td>
            </tr>
            <tr>
                <td valign="top">5.</td>
                <td valign="top">Agama </td>
                <td valign="top">:</td>
                <td valign="top">
                <select name="jenis_kelamin" class="form-control">';
                    $agamas = Agama::all();
                    foreach($agamas as $agama){
                        echo '<option value="'.$agama->id.'">'.$agama->nama.'</option>';
                    }
                echo '
                </select>
                </td>
            </tr>
            <tr>
                <td valign="top">6.</td>
                <td valign="top">Alamat/tempat tinggal siswa </td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", ".$murid->kecamatan }}</td>
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
                <td valign="top">{{ $murid->nama_ayah }}</td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Ibu</td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->nama_ibu }}</td>
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
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Ibu</td>
                <td valign="top">:</td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">9.</td>
                <td valign="top">Alamat Rumah </td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", ".$murid->kecamatan }}</td>
            </tr>
            <tr>
                <td valign="top">10.</td>
                <td valign="top">Nama Wali Siswa </td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->nama_wali }}</td>
            </tr>
            <tr>
                <td valign="top">11.</td>
                <td valign="top">Pekerjaan Wali </td>
                <td valign="top">:</td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top">12.</td>
                <td valign="top">Alamat Rumah Wali </td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->alamat_wali }}</td>
            </tr>
            <tr>
                <td valign="top">13.</td>
                <td valign="top">Diterima Menjadi Siswa </td>
                <td valign="top"></td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">a. Di kelas</td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->diterima_kelas }}</td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">b. Mulai tanggal</td>
                <td valign="top">:</td>
                <td valign="top"></td>
            </tr>
            <tr>
                <td valign="top"></td>
                <td valign="top">c. Asal Sekolah</td>
                <td valign="top">:</td>
                <td valign="top">{{ $murid->sekolah_asal }}</td>
            </tr>
            <tr>
                <td valign="top">14.</td>
                <td valign="top">No. Ijazah </td>
                <td valign="top">:</td>
                <td valign="top">-</td>
            </tr>
            <tr>
                <td valign="top">15.</td>
                <td valign="top">Tanggal Ijazah </td>
                <td valign="top">:</td>
                <td valign="top">-</td>
            </tr>
        </table>';
    }
   
}
