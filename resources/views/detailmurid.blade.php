@extends('layouts.main')

@section('modulhead')
<style>
  #loadingOverlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 2000; /* di atas modal bootstrap */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
</style>
@endsection
@section('content')


<div class="main-content container-fluid">
    <section class="section">
        <div class="row mb-4">
            <div class="col-md-5">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h3 class='card-heading p-1 pl-3'>Buku Induk</h3>
                        <div class="d-flex ">
                             <a href="javascript: history.go(-1)" class="btn btn-danger">Kembali</a> 
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ $murid->photo == null ? url('assets/images/avatar/no_image.jpg') : url('storage/'.$murid->photo) }}" width="100%">
                                    </div>
                                    <div class="col-8">
                                        <div>
                                            <h4 class="text-primary">{{ $murid->nama }}</h4>
                                            <p>{{ $murid->no_induk."/".$murid->nisn }}</p>
                                        </div>
                                        <a href="#" target="_blank" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                                            Unggah Foto</a>
                                        <a href="{{ url('/cetak?pd_id='.$murid->id) }}" target="_blank" class="btn btn-rounded btn-primary"><span
                                            class="btn-icon-left text-primary"><i class="fa fa-print"></i>
                                        </span>Cetak</a>
                                        <div class="modal fade" id="uploadModal">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Unggah Foto</h5>
                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="{{ url('/upload') }}" method="post" enctype="multipart/form-data">
                                                        @csrf
                                                    <div class="modal-body">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Unggah</span>
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="file">
                                                                    <input type="hidden" name="pesertadidik_id" value="{{ $murid->id }}">
                                                                    <label class="custom-file-label">Pilih Foto</label>
                                                                </div>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" name="submit" class="btn btn-primary">Unggah</button>
                                                    </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Detail</h4>
                        <div class="d-flex ">
                             <a href="javascript: history.go(-1)" class="btn btn-warning">Edit</a> 
                        </div>
                    </div>
                    <div class="card-body">
                        <table>
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
                                <td valign="top">{{ $murid->jenis_kelamin }}</td>
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
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Nilai</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="list-group list-group-horizontal-sm mb-1 text-center" role="tablist">
                                @foreach($rombels as $rombel)
                                    <a class="list-group-item list-group-item-action{{ $no == 1 ? ' active' : '' }}" id="list-{{ $no }}-list"
                                        data-toggle="list" href="#list-{{ $no++ }}" role="tab">{{ $rombel->semester_id }}</a>
                                @endforeach
                            </div>
                            @php
                            $no = 1;
                            @endphp
                            <div class="tab-content text-justify">
                                @foreach($rombels as $rombel)
                                @php
                                $thn_kurikulum = date('Y', strtotime($rombel->rombonganbelajar->kurikulum->mulai_berlaku));
                                $kelompoks = App\Models\Kelompok::where('kurikulum', $thn_kurikulum)->get();
                                @endphp
                                <div class="tab-pane fade{{ $no == 1 ? ' show active' : '' }}" id="list-{{ $no++ }}" role="tabpanel"
                                    aria-labelledby="list-{{ $no-1 }}-list">
                                    <div class="card">
                                        <div class="card-body">
                                            Kelas : {{ $rombel->rombonganbelajar->nama }}<br>
                                            Tahun Pelajaran : {{ $rombel->semester->nama }}<br>
                                        </div>
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Daftar Nilai Peserta Didik</h4>
                                            <div class="d-flex">
                                                <a href="javascript: history.go(-1)" class="btn btn-warning">Edit</a> 
                                            </div>
                                        </div>
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
                                                    <tbody>
                                                        @foreach($kelompoks as $kelompok)
                                                        <tr>
                                                            <th colspan="4">{{ $kelompok->nama_kelompok }}</th>                                                            
                                                        </tr>
                                                        @php
                                                        $no_urut = 1;
                                                        $pembelajarans = App\Models\Pembelajaran::where('rombonganbelajar_id', $rombel->rombonganbelajar_id)->where('kelompok_id', $kelompok->id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                                                        @endphp
                                                        @foreach($pembelajarans as $pembelajaran)
                                                        <tr>
                                                            <td>{{ $no_urut++; }}</td>
                                                            <td>{{ $pembelajaran->nama_mata_pelajaran }}</td>                                                                    
                                                            <td>
                                                                @php
                                                                    $nilai = App\Models\Nilaiakhir::where('pembelajaran_id', $pembelajaran->id)->where('anggotarombel_id', $rombel->id)->first();
                                                                @endphp
                                                                {{ $nilai ? $nilai->nilai : '-' }}
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                        @endforeach
                                                        @php
                                                            $rombelmps = App\Models\Anggotarombel::where('pesertadidik_id', $rombel->pesertadidik_id)
                                                            ->whereHas('rombonganbelajar', function ($query) {
                                                                $query->where('jenisrombel_id', '16');
                                                            })->where('semester_id', $rombel->semester_id)->get();
                                                        @endphp
                                                            @foreach($rombelmps as $rombelmp)
                                                                @php
                                                                $pembelajaranmps = App\Models\Pembelajaran::where('rombonganbelajar_id', $rombelmp->rombonganbelajar_id)->where('no_urut', '<>', null)->orderBy('no_urut', 'asc')->get();
                                                                @endphp
                                                                @foreach($pembelajaranmps as $pembelajaranmp)
                                                                <tr>
                                                                    <td>{{ $no_urut++; }}</td>
                                                                    <td>{{ $pembelajaranmp->nama_mata_pelajaran }}</td>                                                                    
                                                                    <td>
                                                                        @php
                                                                            $nilai = App\Models\Nilaiakhir::where('pembelajaran_id', $pembelajaranmp->id)->where('anggotarombel_id', $rombelmp->id)->first();
                                                                        @endphp
                                                                        {{ $nilai ? $nilai->nilai : '-' }}
                                                                    </td>
                                                                </tr>
                                                                @endforeach
                                                            @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                
                                @endforeach
                            </div>                            
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </section>
</div>

@endsection
@section('modulfoot')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(function() {
        // bind change event to select
        $('#semester_id').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
        $('#rombel_id').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>
@endsection