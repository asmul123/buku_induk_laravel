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
            margin-bottom: 2px; 
        }
        table th, 
        table td { 
            border: 1px solid #000; 
            padding: 4px; 
            font-size: 11px; 
        }
        th { background: #f2f2f2; }
        
        td.head { background: #f2f2f2; }
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
            <td width="30%">
                <span style="text-align:center">
                    <h3 style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif">IDENTITAS MURID</h3>
                    <p>NISN : {{ $murid->nisn }}</p>
                </span>
                <table width="100%">
                    <tr>
                        <td width="5%">1</td>
                        <td width="35%">Nama Murid (Lengkap)</td>
                        <td width="2%">:</td>
                        <td width="58%" valign="top" colspan="2">{{ $murid->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top">2</td>
                        <td valign="top">No. Induk</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->no_induk }}</td>
                    </tr>
                    <tr>
                        <td valign="top">3</td>
                        <td valign="top">Tempat, Tanggal Lahir</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->tempat_lahir.", ".date('d F Y', strtotime($murid->tanggal_lahir)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">4</td>
                        <td valign="top">Jenis Kelamin</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td valign="top">5</td>
                        <td valign="top">Agama</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->agama->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top">6</td>
                        <td valign="top">Status dalam Keluarga</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->status }}</td>
                    </tr>
                    <tr>
                        <td valign="top">7</td>
                        <td valign="top">Anak ke</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->anak_ke }}</td>
                    </tr>
                    <tr>
                        <td valign="top">8</td>
                        <td valign="top">Alamat murid</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", ".$murid->kecamatan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" rowspan="3">9.</td>
                        <td valign="top" colspan="4">Nama Orang Tua </td>
                    </tr>
                    <tr>
                        <td valign="top">a. Ayah</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->nama_ayah }}</td>
                    </tr>
                    <tr>
                        <td valign="top">b. Ibu</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->nama_ibu }}</td>
                    </tr>
                    <tr>
                        <td valign="top">10</td>
                        <td valign="top">Alamat Orang Tua</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", ".$murid->kecamatan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" rowspan="3">11</td>
                        <td valign="top" colspan="4">Pekerjaan</td>
                    </tr>
                    <tr>
                        <td valign="top">a. Ayah</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ App\Models\Pekerjaan::where('id', $murid->kerja_ayah)->first()->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top">b. Ibu</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ App\Models\Pekerjaan::where('id', $murid->kerja_ibu)->first()->nama }}</td>
                    </tr>
                    <tr>
                        <td valign="top">12</td>
                        <td valign="top">Nama Wali Murid</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->nama_wali }}</td>
                    </tr>
                    <tr>
                        <td valign="top">13</td>
                        <td valign="top">Alamat Wali Murid</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->alamat_wali }}</td>
                    </tr>
                    <tr>
                        <td valign="top">14</td>
                        <td valign="top">Pekerjaan Wali Murid</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ ($murid->kerja_wali <> null) ? App\Models\Pekerjaan::where('id', $murid->kerja_wali)->first()->nama : '-' }}</td>
                    </tr>
                    <tr>
                        <td valign="top" rowspan="6">15</td>
                        <td valign="top" colspan="4">Diterima di sekolah ini</td>
                    </tr>
                    <tr>
                        <td valign="top">a. Di kelas</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->diterima_kelas }}</td>
                    </tr>
                    <tr>
                        <td valign="top">b. Mulai tanggal</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ date('d F Y', strtotime($murid->diterima)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">c. Sekolah Asal</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->sekolah_asal }}</td>
                    </tr>
                    <tr>
                        <td valign="top">No. Ijazah </td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->ijazah_smp }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Tanggal Ijazah </td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ date('d F Y', strtotime($murid->tanggal_ijazah_smp)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top" rowspan="3">16</td>
                        <td valign="top" colspan="4">Meninggalkan Sekolah</td>
                    </tr>
                    <tr>
                        <td valign="top">Tanggal</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ date('d F Y', strtotime($murid->tanggal_meninggalkan)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Alasan</td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->alasan_meninggalkan }}</td>
                    </tr>
                    <tr>
                        <td valign="top" rowspan="3">17</td>
                        <td valign="top" colspan="4">Tamat</td>
                    </tr>
                    <tr>
                        <td valign="top">No. Ijazah </td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ $murid->no_ijazah_akhir }}</td>
                    </tr>
                    <tr>
                        <td valign="top">Tanggal Ijazah </td>
                        <td valign="top">:</td>
                        <td valign="top" colspan="2">{{ date('d F Y', strtotime($murid->tanggal_ijazah_akhir)) }}</td>
                    </tr>
                    <tr>
                        <td valign="top">18</td>
                        <td valign="top" colspan="3">Keterangan Lain-lain :
                            <br>
                            {{ $murid->keterangan }}
                        </td>
                        <td valign="top" style="text-align: center" width="30%">
                            <img src="{{ $murid->photo == null ? public_path('assets/images/avatar/no_image.jpg') : public_path('storage/'.$murid->photo) }}" height="120px">
                        </td>
                    </tr>
                </table>
            </td>
            <td width="70%" valign="top">

                <div style="text-align:center">
                    <h3 style="font-family:Trebuchet MS, Arial, Helvetica, sans-serif">HASIL PRESTASI BELAJAR</h3>
                    @php
                        $ang_10 = App\Models\Anggotarombel::where('pesertadidik_id', $murid->id)->whereHas('rombonganbelajar', function ($query) {
                            $query->where('tingkat', '10');
                        })->first();
                        if($ang_10){
                            $program_keahlian = $ang_10->rombonganbelajar->jurusan->nama_jurusan;
                        } else {
                            $program_keahlian = "-";
                        }
                        $ang_11 = App\Models\Anggotarombel::where('pesertadidik_id', $murid->id)->whereHas('rombonganbelajar', function ($query) {
                            $query->where('tingkat', '11');
                        })->first();
                        if($ang_11){
                            $konsentrasi_keahlian = $ang_11->rombonganbelajar->jurusan->nama_jurusan;
                        } else {
                            $konsentrasi_keahlian = "-";
                        }
                    @endphp
                    <p>PROGRAM KEAHLIAN : {{ strtoupper($program_keahlian) }}<br>
                    KONSENTRASI KEAHLIAN : {{ strtoupper($konsentrasi_keahlian) }}</p>
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
                            <td class="head" colspan="{{ count($rombels)+2 }}"><strong>{{ $kelompok->nama_kelompok }}</strong></td>
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
                        <tr>
                            <td colspan="2" rowspan="2">Status Akhir Tahun</td>
                            @foreach($rombels as $rombel)
                            @php
                            $semester = substr($rombel->semester_id, 4);
                            $status = App\Models\Kenaikan::where('anggotarombel_id', $rombel->id);
                            if ($status->count() >= 1){
                                $st = $status->first()->status;
                            } else {
                                $st = 1;
                            }
                            @endphp
                            @if($semester == 2)
                                @if($rombel->rombonganbelajar->tingkat <> 12)
                                <td align="center">{!! $st == 1 ? 'Naik' : '<s>Naik</s>' !!}</td>
                                @else
                                <td align="center">{!! $st == 1 ? 'Lulus' : '<s>Lulus</s>' !!}</td>
                                @endif
                            @else
                                <td rowspan="2">Tahun : {{ substr($rombel->semester_id, 0,4)."/".(int)substr($rombel->semester_id, 0,4)+1 }}</td>
                            @endif
                            @endforeach
                        </tr>
                        <tr>
                            @foreach($rombels as $rombel)
                            @php
                            $semester = substr($rombel->semester_id, 4);
                            $status = App\Models\Kenaikan::where('anggotarombel_id', $rombel->id);
                            if ($status->count() >= 1){
                                $st = $status->first()->status;
                            } else {
                                $st = 2;
                            }
                            @endphp
                            @if($semester == 2)
                                @if($rombel->rombonganbelajar->tingkat <> 12)
                                <td align="center">{!! $st == 1 ? '<s>Tidak Naik</s>' : 'Tidak Naik' !!}</td>
                                @else
                                <td align="center">{!! $st == 1 ? '<s>Tidak Lulus</s>' : 'Tidak Lulus' !!}</td>
                                @endif
                            @endif
                            @endforeach
                        </tr>
                        <tr>
                            <td class="head" colspan="{{ count($rombels)+2 }}"><strong>DATA PRIBADI</strong></td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Sikap</td>
                            @foreach($rombels as $rombel)
                            <td align="center"></td>
                            @endforeach
                        </tr>
                        <tr>
                            <td rowspan="4">2</td>
                            <td colspan="{{ count($rombels)+1 }}">Absensi</td>
                        </tr>
                        <tr>
                            <td>Sakit</td>
                            @foreach($rombels as $rombel)
                            @php
                                $absen = App\Models\Absensi::where('anggotarombel_id', $rombel->id);
                                if($absen->count() >= 1){
                                    $abcs = $absen->first()->sakit;
                                } else {
                                    $abcs = '-';
                                }
                            @endphp
                            <td align="center">{{ $abcs }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Izin</td>
                            @foreach($rombels as $rombel)
                            @php
                                $absen = App\Models\Absensi::where('anggotarombel_id', $rombel->id);
                                if($absen->count() >= 1){
                                    $abci = $absen->first()->izin;
                                } else {
                                    $abci = '-';
                                }
                            @endphp
                            <td align="center">{{ $abci }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td>Alpa</td>
                            @foreach($rombels as $rombel)
                            @php
                                $absen = App\Models\Absensi::where('anggotarombel_id', $rombel->id);
                                if($absen->count() >= 1){
                                    $abca = $absen->first()->alpa;
                                } else {
                                    $abca = '-';
                                }
                            @endphp
                            <td align="center">{{ $abca }}</td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
