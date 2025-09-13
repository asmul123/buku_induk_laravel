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
                    <div class="card-header">
                        <h3 class='card-heading p-1 pl-3'>Buku Induk</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <img src="{{ url('assets/images/avatar/no_image.jpg') }}" width="100%">
                                    </div>
                                    <div class="col-8">
                                        <div>
                                            <h4 class="text-primary">{{ $murid->nama }}</h4>
                                            <p>{{ $murid->no_induk."/".$murid->nisn }}</p>
                                        </div>
                                        <a href="#" target="_blank" class="btn btn-primary" data-toggle="modal" data-target="#uploadModal">
                                            Unggah Foto</a>
                                        <a href="#" target="_blank" class="btn btn-rounded btn-primary"><span
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
                                                    <form action="#" method="post" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                            <div class="input-group mb-3">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text">Unggah</span>
                                                                </div>
                                                                <div class="custom-file">
                                                                    <input type="file" class="custom-file-input" name="fileToUpload">
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
                             <a href="javascript: history.go(-1)" class="btn btn-warning">Kembali</a> 
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
                                <td valign="top">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", Kec. ".$murid->kecamatan }}</td>
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
                                <td valign="top">{{ $murid->alamat.", RT. ".$murid->rt.", RW. ".$murid->rw.", Ds./Kel. ".$murid->desa_kelurahan.", Kec. ".$murid->kecamatan }}</td>
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
                                <td valign="top">{{ App\Models\Pekerjaan::where('id', $murid->kerja_wali)->first()->nama }}</td>
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
                <div class="card ">
                    <div class="card-header">
                        <h4>Daftar Nilai</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills mb-4">
                            
                                <li class="nav-item">
                                <a href="#tab-1" class="nav-link active" data-toggle="tab" aria-expanded="true">20251</a>
                                </li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab-1" class="tab-pane1">
                                <div class="row">
                                    <div class="col-md-12"> 
                                        <div class="card-body">
                                            Kelas : ....<br>
                                            Tahun Pelajaran : ....<br>
                                        </div>
                                        <div class="card-header">
                                            <h4 class="card-title">Daftar Nilai Peserta Didik</h4>
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
                                                        <tr>
                                                            <th colspan="4">#</th>
                                                        </tr>
                                                        <tr>
                                                                <td>nomap</td>
                                                                <td>namamapel</td>                                                                    
                                                                <td>nilai</td>
                                                            </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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