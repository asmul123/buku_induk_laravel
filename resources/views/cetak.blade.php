<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Buku Induk</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { text-align: center; margin-bottom: 20px; }
        /* default semua tabel ada border */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 5px; 
        }
        table th, 
        table td { 
            border: 1px solid #000; 
            padding: 6px; 
            font-size: 11px; 
        }
        th { background: #f2f2f2; }

        /* khusus tabel yang dikasih class no-border */
        table.no-border, 
        table.no-border th, 
        table.no-border td {
            border: none !important;
        }
    </style>
</head>
<body>
    <table width="100%">
        <tr>
            <td width="35%">
                <table width="100%" class="no-border">
                    <tr>
                        <td colspan="4">
                            <table>
                                <tr>
                                    <td width="20%">
                                        <img src="{{ $murid->photo == null ? public_path('assets/images/avatar/no_image.jpg') : public_path('storage/'.$murid->photo) }}" width="100%"><br>
                                    </td>
                                    <td valign="top">
                                        NIS : {{ $murid->no_induk }}<br>
                                        NISN : {{ $murid->nisn }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <hr>
                        </td>
                    </tr>
                    <tr>
                        <td width="5%">1.</td>
                        <td width="40%">Nama Lengkap </td>
                        <td width="2%">:</td>
                        <td width="53%" valign="top">{{ $murid->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top">2.</td>
                        <td valign="top">Jenis Kelamin </td>
                        <td valign="top">:</td>
                        <td valign="top">{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td valign="top">3.</td>
                        <td valign="top">Tempat, Tanggal Lahir </td>
                        <td valign="top">:</td>
                        <td valign="top">{{ $murid->tempat_lahir.", ".date('d F Y', strtotime($murid->tanggal_lahir)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">4.</td>
                        <td valign="top">Warga Negara</td>
                        <td valign="top">:</td>
                        <td valign="top">Indonesia</td>
                    </tr>
                    <tr>
                        <td valign="top">5.</td>
                        <td valign="top">Agama </td>
                        <td valign="top">:</td>
                        <td valign="top">{{ $murid->agama->nama }}</td>
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
                        <td valign="top">{{ App\Models\Pekerjaan::where('id', $murid->kerja_ayah)->first()->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top"></td>
                        <td valign="top">b. Ibu</td>
                        <td valign="top">:</td>
                        <td valign="top">{{ App\Models\Pekerjaan::where('id', $murid->kerja_ibu)->first()->nama }}</td>
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
                        <td valign="top">{{ ($murid->kerja_wali <> null) ? App\Models\Pekerjaan::where('id', $murid->kerja_wali)->first()->nama : '-' }}</td>
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
                        <td valign="top">{{ date('d F Y', strtotime($murid->diterima)) }}</td>
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
                </table>
            </td>
            <td width="65%" valign="top">

                <div style="text-align:center">
                    <h3 style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif">HASIL PRESTASI BELAJAR</h3>
                </div>
                <table>
                    <thead>
                        <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2">Mata Pelajaran</th>
                            @foreach($rombels as $rombel)
                            <th>{{ $rombel->semester->nama }}
                                <hr>{{ $rombel->rombonganbelajar->nama }}
                            </th>
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($rombels as $rombel)
                            @php
                                ${'tot'.$rombel->semester_id} = 0;
                                ${'jmp'.$rombel->semester_id} = 0;
                            @endphp
                            <th>NILAI</th>
                            @endforeach            
                        </tr>
                    </thead>
                    @php
                        $thn_kurikulum = date('Y', strtotime($rombel->rombonganbelajar->kurikulum->mulai_berlaku));
                        $kelompoks = App\Models\Kelompok::where('kurikulum', $thn_kurikulum)->get();
                    @endphp
                    <tbody>
                        @foreach($kelompoks as $kelompok)
                        <tr>
                            <td colspan="{{ count($rombels)+2 }}"><strong>{{ $kelompok->nama_kelompok }}</strong></td>
                        </tr>
                            @php
                            $pesertaId = $murid->id;
                            $no_urut = 1;
                            $pembelajarans = App\Models\Pembelajaran::with('rombonganbelajar')
                            ->whereHas('rombonganbelajar.anggotarombel', function($q) use ($pesertaId) {
                                $q->where('pesertadidik_id', $pesertaId);
                            })->whereHas('rombonganbelajar', function($q) {
                                $q->where('jenisrombel_id', '1');
                            })->where('kelompok_id', $kelompok->id)
                            ->where('no_urut', '<>', null)
                            ->orderBy('no_urut', 'asc')->get()->groupBy('matapelajaran_id');
                            @endphp
                        @foreach($pembelajarans as $pembelajaran => $items)
                            @php
                                $mapel_id = $items->first()->matapelajaran_id;
                            $cek_nilai_akhir = App\Models\Nilaiakhir::with('pembelajaran')
                            ->whereHas('pembelajaran', function($q) use ($mapel_id){
                                $q->where('matapelajaran_id', $mapel_id);
                            })->with('anggotarombel')
                            ->whereHas('anggotarombel', function($q) use ($pesertaId){
                                $q->where('pesertadidik_id', $pesertaId);
                            })->count();
                            @endphp

                            @if($cek_nilai_akhir <> 0)
                            <tr>
                                <td align="center">{{ $no_urut++ }}</td>
                                <td>{{ $items->first()->nama_mata_pelajaran }}</td>
                                @foreach($rombels as $rombel)
                                @php
                                    $pembelajaranini = App\Models\Pembelajaran::where('matapelajaran_id', $mapel_id)->where('rombonganbelajar_id', $rombel->rombonganbelajar_id)->where('no_urut', '<>', null)->first();
                                    if($pembelajaranini){
                                        $pembelajaran_id = $pembelajaranini->id;
                                        $nilai = App\Models\Nilaiakhir::where('pembelajaran_id', $pembelajaran_id)->where('anggotarombel_id', $rombel->id)->first();
                                        $nilai ? ${'tot'.$rombel->semester_id} = ${'tot'.$rombel->semester_id} + $nilai->nilai : false;
                                        $nilai ? ${'jmp'.$rombel->semester_id}++ : false;
                                    } else {
                                        $nilai = '';
                                    }
                                @endphp                            
                                <td align="center">{{ $nilai ? $nilai->nilai : '-' }}</td>
                                @endforeach
                            </tr>
                            @endif
                        @endforeach
                        @endforeach
                        <tr>
                            <td colspan="2">Jumlah Nilai</td>
                            @foreach($rombels as $rombel)
                            <td align="center">{{ ${'tot'.$rombel->semester_id} <> 0 ? ${'tot'.$rombel->semester_id} : '-' }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="2">Rata-rata</td>
                            @foreach($rombels as $rombel)
                            <td align="center">{{ ${'jmp'.$rombel->semester_id} <> 0 ? number_format(${'tot'.$rombel->semester_id}/${'jmp'.$rombel->semester_id},2) : '-' }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
