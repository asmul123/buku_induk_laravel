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
                                        <a href="#" target="_blank" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#uploadModal">
                                            Unggah Foto</a>
                                        <a href="{{ url('/cetak?pd_id='.$murid->id) }}" target="_blank" class="btn btn-sm btn-primary"><span
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
                             <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalGeneral" id="btn-edit-biodata" data-id="{{ $murid->id }}">Edit</a> 
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
                                <td valign="top">{{ $murid->warga_negara }}</td>
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
                                <td valign="top"></td>
                                <td valign="top">d. No. Ijazah </td>
                                <td valign="top">:</td>
                                <td valign="top">{{ $murid->ijazah_smp }}</td>
                            </tr>
                            <tr>
                                <td valign="top"></td>
                                <td valign="top">e. Tanggal Ijazah </td>
                                <td valign="top">:</td>
                                <td valign="top">{{ date('d F Y', strtotime($murid->tanggal_ijazah_smp)) }}</td>
                            </tr>
                            <tr>
                                <td valign="top">14.</td>
                                <td valign="top">Meninggalkan Sekolah </td>
                                <td valign="top"></td>
                                <td valign="top"></td>
                            </tr>
                            <tr>
                                <td valign="top"></td>
                                <td valign="top">a. Tanggal</td>
                                <td valign="top">:</td>
                                <td valign="top">{{ date('d F Y', strtotime($murid->tanggal_meninggalkan)) }}</td>
                            </tr>
                            <tr>
                                <td valign="top"></td>
                                <td valign="top">b. Alasan</td>
                                <td valign="top">:</td>
                                <td valign="top">{{ $murid->alasan_meninggalkan }}</td>
                            </tr>
                            <tr>
                                <td valign="top">15.</td>
                                <td valign="top">Tamat </td>
                                <td valign="top"></td>
                                <td valign="top"></td>
                            </tr>
                            <tr>
                                <td valign="top"></td>
                                <td valign="top">a. No. Ijazah</td>
                                <td valign="top">:</td>
                                <td valign="top">{{ $murid->no_ijazah_akhir }}</td>
                            </tr>
                            <tr>
                                <td valign="top"></td>
                                <td valign="top">b. Tanggal</td>
                                <td valign="top">:</td>
                                <td valign="top">{{ date('d F Y', strtotime($murid->tanggal_ijazah_akhir)) }}</td>
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
                                                <a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalGeneral" id="btn-edit-nilai" data-id="{{ $rombel->id }}">Edit</a>  
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
                                    
                                    <!-- Kehadiran Section -->
                                    <div class="card mt-3">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Kehadiran</h4>
                                            <div class="d-flex">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalGeneral" id="btn-edit-absensi" data-anggotarombel="{{ $rombel->id }}">Edit</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $absensi = App\Models\Absensi::where('anggotarombel_id', $rombel->id)->first();
                                            @endphp
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Sakit</label>
                                                        <p class="form-control-plaintext"><strong>{{ $absensi ? $absensi->sakit : '-' }}</strong> hari</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Izin</label>
                                                        <p class="form-control-plaintext"><strong>{{ $absensi ? $absensi->izin : '-' }}</strong> hari</p>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Alfa</label>
                                                        <p class="form-control-plaintext"><strong>{{ $absensi ? $absensi->alpa : '-' }}</strong> hari</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @php
                                        $isSemesterGenap = (int)substr($rombel->semester_id, -1) % 2 == 0;
                                    @endphp
                                    
                                    @if($isSemesterGenap)
                                    <!-- Status Kenaikan Kelas / Kelulusan Section -->
                                    <div class="card mt-3">
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <h4 class="card-title">Status Kenaikan Kelas / Kelulusan</h4>
                                            <div class="d-flex">
                                                <a href="javascript:void(0)" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalGeneral" id="btn-edit-kenaikan" data-anggotarombel="{{ $rombel->id }}">Edit</a>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            @php
                                                $kenaikan = App\Models\Kenaikan::where('anggotarombel_id', $rombel->id)->first();
                                                $tingkat = $rombel->rombonganbelajar->tingkat;
                                            @endphp
                                            <div class="form-group">
                                                <label>Status</label>
                                                <p class="form-control-plaintext">
                                                    @if($kenaikan)
                                                        @if($tingkat == 12 && $isSemesterGenap)
                                                            @if($kenaikan->status == 3)
                                                                <span class="badge bg-success">Lulus</span>
                                                            @elseif($kenaikan->status == 4)
                                                                <span class="badge bg-danger">Tidak Lulus</span>
                                                            @else
                                                                <span class="badge bg-secondary">-</span>
                                                            @endif
                                                        @else
                                                            @if($kenaikan->status == 1)
                                                                <span class="badge bg-success">Naik Kelas</span>
                                                            @elseif($kenaikan->status == 2)
                                                                <span class="badge bg-danger">Tidak Naik Kelas</span>
                                                            @else
                                                                <span class="badge bg-secondary">-</span>
                                                            @endif
                                                        @endif
                                                    @else
                                                        <span class="badge bg-secondary">-</span>
                                                    @endif
                                                </p>
                                            </div>
                                            @if($kenaikan && $kenaikan->nama_kelas && !($tingkat == 12 && $isSemesterGenap))
                                            <div class="form-group">
                                                <label>Kelas Tujuan</label>
                                                <p class="form-control-plaintext">{{ $kenaikan->nama_kelas }}</p>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>                                
                                @endforeach
                            </div>                            
                        </div>
                    </div>
                </div>               
            </div>
        </div>
    </section>

    <!-- Template Modal -->
    <div class="modal fade text-left w-100" id="modalGeneral" tabindex="-1" role="dialog"
    aria-labelledby="myModalLabel16" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content">
                
            <form id="thisForm" method="POST" action="#">
            @csrf
                <div class="modal-header">
                <h4 class="modal-title" id="modal-title">No Title</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
                </div>
                <div class="modal-body">
                    <div id="modal-body">
                    </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-primary" id="btnSimpan">
                    <span class="btn-icon-left"><i class="fa fa-save"></i></span>
                    Simpan
                </button>
                <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Tutup</span>
                </button>
                </div>
            </form>
            </div>
        </div>
    </div>
    
    <!-- Modal Success -->
    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <h5 class="mb-3">Berhasil!</h5>
                    <p id="pesan">Data berhasil disimpan.</p>
                    <button type="button" class="btn btn-light mt-2" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Overlay Spinner -->
    <div id="loadingOverlay" class="d-none">
        <div class="overlay-content">
            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
            <p class="mt-3 text-white">Sedang memproses...</p>
        </div>
    </div>
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

    // Helper function untuk show/hide tombol footer berdasarkan ada tidaknya tombol submit di body
    function toggleFooterButton() {
        // Cek apakah ada tombol dengan id "btnSubmit" di dalam modal body
        if($('#modal-body #btnSubmit').length > 0) {
            // Ada tombol di body, sembunyikan tombol footer
            $('#btnSimpan').hide();
        } else {
            // Tidak ada tombol di body, tampilkan tombol footer
            $('#btnSimpan').show();
        }
    }

    $('body').on('click', '#btn-edit-biodata', function () {
            let murid_id = $(this).data('id');
            
            //fetch detail post with ajax
            $.ajax({
                url: "{{ url('/editmurid?murid_id=') }}"+murid_id+"&aksi=edit",
                type: "GET",
                cache: false,
                success:function(response){
                    $('#modal-title').html("Edit Biodata");
                    $('#modal-body').html(response);
                    $('#thisForm').removeAttr('action');
                    toggleFooterButton();
                }
            });
    });

    $('body').on('click', '#btn-edit-nilai', function () {
            let rombel_id = $(this).data('id');
            
            //fetch detail post with ajax
            $.ajax({
                url: "{{ url('/editnilai?rombel_id=') }}"+rombel_id,
                type: "GET",
                cache: false,
                success:function(response){
                    $('#modal-title').html("Edit Nilai");
                    $('#modal-body').html(response);
                    $('#thisForm').removeAttr('action');
                    toggleFooterButton();
                }
            });
    });

    $('body').on('click', '#btn-edit-absensi', function () {
            let anggotarombel_id = $(this).data('anggotarombel');
            
            //fetch detail post with ajax
            $.ajax({
                url: "{{ url('/editabsensi?anggotarombel_id=') }}"+anggotarombel_id,
                type: "GET",
                cache: false,
                success:function(response){
                    $('#modal-title').html("Edit Kehadiran");
                    $('#modal-body').html(response);
                    $('#thisForm').attr('action', '{{ url('/simpan-absensi') }}');
                    toggleFooterButton();
                }
            });
    });

    $('body').on('click', '#btn-edit-kenaikan', function () {
            let anggotarombel_id = $(this).data('anggotarombel');
            
            //fetch detail post with ajax
            $.ajax({
                url: "{{ url('/editkenaikan?anggotarombel_id=') }}"+anggotarombel_id,
                type: "GET",
                cache: false,
                success:function(response){
                    $('#modal-title').html("Edit Status Kenaikan/Kelulusan");
                    $('#modal-body').html(response);
                    $('#thisForm').attr('action', '{{ url('/simpan-kenaikan') }}');
                    toggleFooterButton();
                }
            });
    });

    $("#thisForm").on("submit", function (e) {
    e.preventDefault();

    let form = $(this);
    let url = form.attr('action') || "{{ url('/updateinduk') }}";
    let data = form.serialize();

    // Tampilkan overlay spinner
    $("#loadingOverlay").removeClass("d-none");

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (response) {

                // Tampilkan modal success
                document.getElementById('pesan').innerText = response.message || "Berhasil menyimpan Data";
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            },
            error: function () {
                alert("Terjadi kesalahan, coba lagi." + error);
            },
            complete: function () {
                // Sembunyikan overlay spinner
                $("#loadingOverlay").addClass("d-none");
                window.location.reload();
            }
        });
    });

</script>
@endsection