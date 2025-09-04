<?php

namespace App\Http\Controllers;
use App\Models\Dapodik;
use App\Models\Pesertadidik;
use App\Models\Sekolah;
use App\Models\Ptk;
use App\Models\Rombonganbelajar;
use App\Models\Anggotarombel;
use App\Models\Pembelajaran;

use Illuminate\Support\Facades\Http;

class SingkronController extends Controller
{
    
    public function index()
    {
        
        $dapodik = Dapodik::where('id', '1')->first();
        $skldbcount = Sekolah::get()->count();
        $ptkdbcount = Ptk::get()->count();
        $rombeldbcount = Rombonganbelajar::get()->count();
        $pddbcount = Pesertadidik::get()->count();
        $sekolah = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
                'npsn' => '20209201'
            ]);
        $pendidik = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getGtk", [
            'npsn' => '20209201'
            ]);

        $rombongan_belajar = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getRombonganBelajar", [
            'npsn' => '20209201'
            ]);
        
        $peserta_didik = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getPesertaDidik", [
            'npsn' => '20209201'
            ]);

        $skl = $sekolah->json();
        $sklcount = count($skl['rows']);
        $pd = $peserta_didik->json();
        $pdcount = count($pd['rows']);
        $ptk = $pendidik->json();
        $ptkcount = count($ptk['rows']);
        $gurucount = array_count_values(array_column($ptk['rows'], 'jenis_ptk_id'))['92'];
        $tucount = array_count_values(array_column($ptk['rows'], 'jenis_ptk_id'))['93'];
        $rombel = $rombongan_belajar->json();
        $rombelcount = count($rombel['rows']);

        $data = [
            'menu' => 'singkron',
            'smenu' => 'dapodik',
            'sklcount' => $sklcount,
            'pdcount' => $pdcount,
            'ptkcount' => $ptkcount,
            'rombelcount' => $rombelcount,
            'skldbcount' => $skldbcount,
            'ptkdbcount' => $ptkdbcount,
            'rombeldbcount' => $rombeldbcount,
            'pddbcount' => $pddbcount
        ];
        return view('singkron', $data);
        // foreach($data as $d){
        //     echo $d['rombongan_belajar_id']." - ".$d['nama']."<br>";
        // }
        // dd($data);
    }

    public function sekolah()
    {
        $dapodik = Dapodik::where('id', '1')->first();
        $sekolah = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
                'npsn' => '20209201'
            ]);
        $skl = $sekolah->json()['rows'];
        $cekskl = Sekolah::where('id', $skl['sekolah_id'])->get()->count();
        if($cekskl >=1){
            $data = [
                'nama' => $skl['nama'],
                'nss' => $skl['nss'],
                'npsn' => $skl['npsn'],
                'bentuk_pendidikan_id' => $skl['bentuk_pendidikan_id'],
                'status_sekolah' => $skl['status_sekolah'],
                'alamat' => $skl['alamat_jalan'].", RT.".$skl['rt'].", RW.".$skl['rw'].", ".$skl['dusun'],
                'kode_wilayah' => $skl['kode_wilayah'],
                'kode_pos' => $skl['kode_pos'],
                'no_telp' => $skl['nomor_telepon'],
                'no_fax' => $skl['nomor_fax'],
                'email' => $skl['email'],
                'website' => $skl['website'],
                'lintang' => $skl['lintang'],
                'bujur' => $skl['bujur'],
                'desa_kelurahan' => $skl['desa_kelurahan'],
                'kecamatan' => $skl['kecamatan'],
                'kabupaten' => $skl['kabupaten_kota'],
                'provinsi' => $skl['provinsi']
            ];
            Sekolah::where('id', $skl['sekolah_id'])->update($data);
            return redirect()->back()->with('success', 'Berhasil mengubah Memperbaharui data Sekolah');
        } else {
            $data = [
                'id' => $skl['sekolah_id'],
                'nama' => $skl['nama'],
                'nss' => $skl['nss'],
                'npsn' => $skl['npsn'],
                'bentuk_pendidikan_id' => $skl['bentuk_pendidikan_id'],
                'status_sekolah' => $skl['status_sekolah'],
                'alamat' => $skl['alamat_jalan'].", RT.".$skl['rt'].", RW.".$skl['rw'].", ".$skl['dusun'],
                'kode_wilayah' => $skl['kode_wilayah'],
                'kode_pos' => $skl['kode_pos'],
                'no_telp' => $skl['nomor_telepon'],
                'no_fax' => $skl['nomor_fax'],
                'email' => $skl['email'],
                'website' => $skl['website'],
                'lintang' => $skl['lintang'],
                'bujur' => $skl['bujur'],
                'desa_kelurahan' => $skl['desa_kelurahan'],
                'kecamatan' => $skl['kecamatan'],
                'kabupaten' => $skl['kabupaten_kota'],
                'provinsi' => $skl['provinsi']
            ];
            Sekolah::create($data);
            return redirect()->back()->with('success', 'Berhasil Menambah data Sekolah');
        }
    }

    public function ptk()
    {
        $dapodik = Dapodik::where('id', '1')->first();
        $sekolah = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
                'npsn' => '20209201'
            ]);
        $sekolah_id = $sekolah->json()['rows']['sekolah_id'];
        $update = 0;
        $add = 0;
        $ptk = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getGtk", [
                'npsn' => '20209201'
            ]);
        $ptks = $ptk->json()['rows'];
        foreach($ptks as $ptk){
            $cekptk = Ptk::where('id', $ptk['ptk_id'])->get()->count();
            if($cekptk >=1){
                $data = [
                    'sekolah_id' => $sekolah_id,
                    'nama' => $ptk['nama'],
                    'nuptk' => $ptk['nuptk'],
                    'nip' => $ptk['nip'],
                    'jenis_kelamin' => $ptk['jenis_kelamin'],
                    'tempat_lahir' => $ptk['tempat_lahir'],
                    'tanggal_lahir' => $ptk['tanggal_lahir'],
                    'nik' => $ptk['nik'],
                    'jenis_ptk_id' => $ptk['jenis_ptk_id'],
                    'agama_id' => $ptk['agama_id'],
                    'status_kepegawaian_id' => $ptk['status_kepegawaian_id']
                ];
                Ptk::where('id', $ptk['ptk_id'])->update($data);
                $update++;
            } else {
                $data = [
                    'id' => $ptk['ptk_id'],
                    'sekolah_id' => $sekolah_id,
                    'nama' => $ptk['nama'],
                    'nuptk' => $ptk['nuptk'],
                    'nip' => $ptk['nip'],
                    'jenis_kelamin' => $ptk['jenis_kelamin'],
                    'tempat_lahir' => $ptk['tempat_lahir'],
                    'tanggal_lahir' => $ptk['tanggal_lahir'],
                    'nik' => $ptk['nik'],
                    'jenis_ptk_id' => $ptk['jenis_ptk_id'],
                    'agama_id' => $ptk['agama_id'],
                    'status_kepegawaian_id' => $ptk['status_kepegawaian_id']
                ];
                Ptk::create($data);
                $add++;
            }
        }
        return redirect()->back()->with('success', 'Berhasil Menambah '. $add.' PTK, dan Mengubah '.$update.' data PTK');
    }

    public function pd()
    {
        $dapodik = Dapodik::where('id', '1')->first();
        $sekolah = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
                'npsn' => '20209201'
            ]);
        $sekolah_id = $sekolah->json()['rows']['sekolah_id'];
        $update = 0;
        $add = 0;
        $updateang = 0;
        $addang = 0;
        $pesertadidik = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getPesertaDidik", [
                'npsn' => '20209201'
            ]);
        $pds = $pesertadidik->json()['rows'];
        foreach($pds as $pd){
            $cekpd = Pesertadidik::where('id', $pd['peserta_didik_id'])->get()->count();
            if($cekpd >=1){
                $data = [
                    'sekolah_id' => $sekolah_id,
                    'nama' => $pd['nama'],
                    'no_induk' => $pd['nipd'],
                    'nisn' => $pd['nisn'],
                    'nik' => $pd['nik'],
                    'jenis_kelamin' => $pd['jenis_kelamin'],
                    'tempat_lahir' => $pd['tempat_lahir'],
                    'tanggal_lahir' => $pd['tanggal_lahir'],
                    'agama_id' => $pd['agama_id'],
                    'anak_ke' => $pd['anak_keberapa'],
                    'sekolah_asal' => $pd['sekolah_asal'],
                    'diterima' => $pd['tanggal_masuk_sekolah'],
                    'email' => $pd['email'],
                    'nama_ayah' => $pd['nama_ayah'],
                    'nama_ibu' => $pd['nama_ibu'],
                    'kerja_ayah' => $pd['pekerjaan_ayah_id'],
                    'kerja_ibu' => $pd['pekerjaan_ibu_id'],
                    'nama_wali' => $pd['nama_wali'],
                    'kerja_wali' => $pd['pekerjaan_wali_id']
                ];
                Pesertadidik::where('id', $pd['peserta_didik_id'])->update($data);
                $update++;
            } else {
                $data = [
                    'id' => $pd['peserta_didik_id'],
                    'sekolah_id' => $sekolah_id,
                    'nama' => $pd['nama'],
                    'no_induk' => $pd['nipd'],
                    'nisn' => $pd['nisn'],
                    'nik' => $pd['nik'],
                    'jenis_kelamin' => $pd['jenis_kelamin'],
                    'tempat_lahir' => $pd['tempat_lahir'],
                    'tanggal_lahir' => $pd['tanggal_lahir'],
                    'agama_id' => $pd['agama_id'],
                    'anak_ke' => $pd['anak_keberapa'],
                    'sekolah_asal' => $pd['sekolah_asal'],
                    'diterima' => $pd['tanggal_masuk_sekolah'],
                    'email' => $pd['email'],
                    'nama_ayah' => $pd['nama_ayah'],
                    'nama_ibu' => $pd['nama_ibu'],
                    'kerja_ayah' => $pd['pekerjaan_ayah_id'],
                    'kerja_ibu' => $pd['pekerjaan_ibu_id'],
                    'nama_wali' => $pd['nama_wali'],
                    'kerja_wali' => $pd['pekerjaan_wali_id']
                ];
                Pesertadidik::create($data);
                $add++;
            }
            $cekanggotapd = Anggotarombel::where('id', $pd['anggota_rombel_id'])->get()->count();
            if($cekanggotapd >= 1){
                $data = [
                    'sekolah_id' => $sekolah_id,
                    'semester_id' => $pd['semester_id'],
                    'rombonganbelajar_id' => $pd['rombongan_belajar_id'],
                    'pesertadidik_id' => $pd['peserta_didik_id']
                ];
                Anggotarombel::where('id', $pd['anggota_rombel_id'])->update($data);
                $updateang++;
            } else {
                $data = [
                    'id' => $pd['anggota_rombel_id'],
                    'sekolah_id' => $sekolah_id,
                    'semester_id' => $pd['semester_id'],
                    'rombonganbelajar_id' => $pd['rombongan_belajar_id'],
                    'pesertadidik_id' => $pd['peserta_didik_id']
                ];
                Anggotarombel::create($data);
                $addang++;
            }
        }
        return redirect()->back()->with('success', 'Berhasil Menambah '. $add.' Murid, dan Mengubah '.$update.' data Murid, Menambah '. $addang .' Anggota Rombel, dan Mengubah '.$updateang.' data Anggota Rombel');
    }

    public function rombel()
    {
        $dapodik = Dapodik::where('id', '1')->first();
        $sekolah = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getSekolah", [
                'npsn' => '20209201'
            ]);
        $sekolah_id = $sekolah->json()['rows']['sekolah_id'];
        $update = 0;
        $add = 0;
        $updatepem = 0;
        $addpem = 0;
        $updateang = 0;
        $addang = 0;
        $rombel = Http::withHeaders([
            'Authorization' => 'Bearer '.$dapodik->token,
            ])->get("http://".$dapodik->address.":5774/WebService/getRombonganBelajar", [
                'npsn' => '20209201'
            ]);
        $rombels = $rombel->json()['rows'];
        foreach($rombels as $r){
            $cekrombel = Rombonganbelajar::where('id', $r['rombongan_belajar_id'])->get()->count();
            if($cekrombel >=1){
                $data = [
                    'sekolah_id' => $sekolah_id,
                    'semester_id' => $r['semester_id'],
                    'jurusan_id' => $r['jurusan_id'],
                    'jurusan_sp_id' => $r['jurusan_id'],
                    'kurikulum_id' => $r['kurikulum_id'],
                    'nama' => $r['nama'],
                    'ptk_id' => $r['ptk_id'],
                    'tingkat' => $r['tingkat_pendidikan_id'],
                    'jenis_rombel' => $r['jenis_rombel']
                ];
                Rombonganbelajar::where('id', $r['rombongan_belajar_id'])->update($data);
                $update++;
            } else {
                $data = [
                    'id' => $r['rombongan_belajar_id'],
                    'sekolah_id' => $sekolah_id,
                    'semester_id' => $r['semester_id'],
                    'jurusan_id' => $r['jurusan_id'],
                    'jurusan_sp_id' => $r['jurusan_id'],
                    'kurikulum_id' => $r['kurikulum_id'],
                    'nama' => $r['nama'],
                    'ptk_id' => $r['ptk_id'],
                    'tingkat' => $r['tingkat_pendidikan_id'],
                    'jenis_rombel' => $r['jenis_rombel']
                ];
                Rombonganbelajar::create($data);
                $add++;
            }
            $anggotarombels = $r['anggota_rombel'];
            foreach($anggotarombels as $ar){
                $cekanggotapd = Anggotarombel::where('id', $ar['anggota_rombel_id'])->get()->count();
                if($cekanggotapd >= 1){
                    $data = [
                        'sekolah_id' => $sekolah_id,
                        'semester_id' => $r['semester_id'],
                        'rombonganbelajar_id' => $r['rombongan_belajar_id'],
                        'pesertadidik_id' => $ar['peserta_didik_id']
                    ];
                    Anggotarombel::where('id', $ar['anggota_rombel_id'])->update($data);
                    $updateang++;
                } else {
                    $data = [
                        'id' => $ar['anggota_rombel_id'],
                        'sekolah_id' => $sekolah_id,
                        'semester_id' => $r['semester_id'],
                        'rombonganbelajar_id' => $r['rombongan_belajar_id'],
                        'pesertadidik_id' => $ar['peserta_didik_id']
                    ];
                    Anggotarombel::create($data);
                    $addang++;
                }
                if($ar['jenis_pendaftaran_id'] == 1){
                    $data = [
                        'diterima_kelas' => $r['nama']
                    ];
                    Pesertadidik::where('id', $ar['peserta_didik_id'])->update($data);
                }
            }
            $pembelajarans = $r['pembelajaran'];
            foreach($pembelajarans as $p){
                $cekpembelajaran = Pembelajaran::where('id', $p['pembelajaran_id'])->get()->count();
                if($p['induk_pembelajaran_id'] == null){
                    if($cekpembelajaran >= 1){
                        $data = [
                            'sekolah_id' => $sekolah_id,
                            'semester_id' => $r['semester_id'],
                            'rombonganbelajar_id' => $r['rombongan_belajar_id'],
                            'ptk_id' => $p['ptk_id'],
                            'matapelajaran_id' => $p['mata_pelajaran_id'],
                            'nama_mata_pelajaran' => $p['mata_pelajaran_id_str']
                        ];
                        Pembelajaran::where('id', $p['pembelajaran_id'])->update($data);
                        $updatepem++;
                    } else {
                        $data = [
                            'id' => $p['pembelajaran_id'],
                            'sekolah_id' => $sekolah_id,
                            'semester_id' => $r['semester_id'],
                            'rombonganbelajar_id' => $r['rombongan_belajar_id'],
                            'ptk_id' => $p['ptk_id'],
                            'matapelajaran_id' => $p['mata_pelajaran_id'],
                            'nama_mata_pelajaran' => $p['mata_pelajaran_id_str']
                        ];
                        Pembelajaran::create($data);
                        $addpem++;
                    }
                }
            }
        }
        return redirect()->back()->with('success', 'Berhasil Menambah '. $add.' Rombel, dan Mengubah '.$update.' data Rombel, Menambah '. $addang .' Anggota Rombel, dan Mengubah '.$updateang.' data Anggota Rombel, Menambah '. $addpem .' Pembelajaran, dan Mengubah '.$updatepem.' data Pembelajaran');
    }
}
