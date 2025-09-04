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
    <div class="page-title">
        <h3>Buku Induk</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                <h4 class="card-title">Data Buku Induk</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">                        
                        <!-- row -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="profile">
                                    <div class="profile-head">
                                        <div class="photo-content">
                                            <div class="cover-photo"></div>
                                            <div class="profile-photo">
                                                <img src="#" class="img-fluid rounded-circle" alt="">
                                            </div>
                                        </div>
                                        <div class="profile-info">
                                            <div class="row justify-content-center">
                                                <div class="col-xl-7">
                                                <a href="#" target="_blank" class="btn btn-xs btn-rounded btn-primary" data-toggle="modal" data-target="#uploadModal"><span
                                                    class="btn-icon-left text-primary"><i class="fa fa-upload"></i>
                                                </span>Unggah Foto</a>
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
                                                    <div class="row">
                                                        <div class="col-xl-7 col-sm-7 border-right-1 prf-col">
                                                            <div class="profile-name">
                                                                <h4 class="text-primary">Nama</h4>
                                                                <p>NIM/NISN</p>
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
                        <div class="row">
                            <div class="col-lg-5">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Detail Peserta Didik</h4>
                                        <a href="javascript: history.go(-1)" class="btn btn-rounded btn-warning"><span
                                                class="btn-icon-left text-warning"><i class="fa fa-arrow-left color-warning"></i>
                                            </span>Kembali</a>                                                  
                                    </div>
                                    <div class="card-body">
                                        <table>
                                            <tr>
                                                <td width="5%">1.</td>
                                                <td width="40%">Nama Lengkap </td>
                                                <td width="2%">:</td>
                                                <td width="53%" valign="top">Nama</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">2.</td>
                                                <td valign="top">Jenis Kelamin </td>
                                                <td valign="top">:</td>
                                                <td valign="top">JK</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">3.</td>
                                                <td valign="top">Tempat, Tanggal Lahir </td>
                                                <td valign="top">:</td>
                                                <td valign="top">TTL</td>
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
                                                <td valign="top">Agama</td>
                                            </tr>
                                            <tr>
                                                <td valign="top">6.</td>
                                                <td valign="top">Alamat/tempat tinggal siswa </td>
                                                <td valign="top">:</td>
                                                <td valign="top">Alamat</td>
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
                                                <td valign="top">Ayah</td>
                                            </tr>
                                            <tr>
                                                <td valign="top"></td>
                                                <td valign="top">b. Ibu</td>
                                                <td valign="top">:</td>
                                                <td valign="top">Ibu</td>
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
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top"></td>
                                                <td valign="top">b. Ibu</td>
                                                <td valign="top">:</td>
                                                <td valign="top">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td valign="top">9.</td>
                                                <td valign="top">Alamat Rumah </td>
                                                <td valign="top">:</td>
                                                <td valign="top"></td>
                                            </tr>
                                            <tr>
                                                <td valign="top">10.</td>
                                                <td valign="top">Nama Wali Siswa </td>
                                                <td valign="top">:</td>
                                                <td valign="top"></td>
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
                                                <td valign="top"></td>
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
                                                <td valign="top"></td>
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
                                                <td valign="top"></td>
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
                            <div class="col-lg-7">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Daftar Nilai Peserta Didik</h4>
                                        <a href="#" target="_blank" class="btn btn-rounded btn-primary"><span
                                            class="btn-icon-left text-primary"><i class="fa fa-print"></i>
                                        </span>Cetak</a>
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