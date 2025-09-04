<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Daftar Ulang - SPMB SMKN 1 GARUT 2025</title>
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.css">

    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/simple-datatables/style.css">

    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/app.css">
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.png" type="image/x-icon">
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="{{ url('/') }}/assets/images/logo.png" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            
            
                <li class='sidebar-title'>Main Menu</li>            
            
                <li class="sidebar-item  ">
                    <a href="{{ url('/pendaftar') }}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Beranda</span>
                    </a>
                    
                </li>
                <li class="sidebar-item  ">
                  <form action="{{ url('/') }}/logout" method="POST" id="form-logout">
                      @csrf
                      <a href="javascript:;" onclick="parentNode.submit();" class="sidebar-link">
                          <i data-feather="log-out" width="20"></i> 
                          <span>Keluar</span>
                      </a>
                      </form>
                    
                </li>
         
        </ul>
    </div>
    <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
</div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </nav>
            
<div class="main-content container-fluid">
<!-- Contextual classes start -->
<div class="row" id="table-contexual">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <h4 class="card-title">Rekapitulasi Daftar Ulang Siswa Baru</h4>
      </div>
      <div class="card-content">
        <div class="card-body">
          <section class="section">
            <div class="card">
                <div class="card-body">
                    <table class='table table-striped' id="table1">
                        <thead>
                            <tr>
                                <th>Nomor Pendaftaran</th>
                                <th>Nama Murid Baru</th>
                                <th>Tanggal Lahir</th>
                                <th>Asal Sekolah</th>
                                <th>Diterima Pada Program</th>
                                <th>HP</th>
                                <th>HP Ortu</th>
                                <th>HP ALternatif</th>
                                <th>1</th>
                                <th>2</th>
                                <th>3</th>
                                <th>4</th>
                                <th>5</th>
                                <th>6</th>
                                <th>7</th>
                            </tr>
                        </thead>
                        <tbody>
                          @foreach($pendaftars as $pendaftar)
                            <tr>
                                <td>{{ $pendaftar->nomor_pendaftaran }}</td>
                                <td>{{ $pendaftar->nama }}</td>
                                <td>{{ $pendaftar->tanggal_lahir }}</td>
                                <td>{{ $pendaftar->asal_sekolah }}</td>
                                <td>{{ $pendaftar->pilihan_diterima }}</td>
                                <td>{{ $pendaftar->no_hp }}</td>
                                <td>{{ $pendaftar->kontak_ortu }}</td>
                                <td>{{ $pendaftar->kontak_alternatif }}</td>
                                <td>
                                  @php
                                      $user_id = App\Models\User::where('nomor_pendaftaran', $pendaftar->nomor_pendaftaran)->first()->id;
                                      $cek_file_1 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '1');
                                      $file_1 = $cek_file_1->count();
                                  @endphp
                                  @if($file_1 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_1->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_2 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '2');
                                      $file_2 = $cek_file_2->count();
                                  @endphp
                                  @if($file_2 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_2->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_3 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '3');
                                      $file_3 = $cek_file_3->count();
                                  @endphp
                                  @if($file_3 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_3->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_4 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '4');
                                      $file_4 = $cek_file_4->count();
                                  @endphp
                                  @if($file_4 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_4->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_5 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '5');
                                      $file_5 = $cek_file_5->count();
                                  @endphp
                                  @if($file_5 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_5->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_6 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '6');
                                      $file_6 = $cek_file_6->count();
                                  @endphp
                                  @if($file_6 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_6->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                                <td>
                                  @php
                                      $cek_file_7 = App\Models\File::where('user_id', $user_id)->where('jenis_file', '7');
                                      $file_7 = $cek_file_7->count();
                                  @endphp
                                  @if($file_7 >= 1)
                                      <a href="{{ url('storage/'.$cek_file_7->first()->file) }}" class="badge bg-primary">Lihat Berkas</a>
                                  @else
                                      <span class="badge bg-warning">Belum Diunggah</span>
                                  @endif
                                </td>
                            </tr>
                          @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </section>
        </div>        
      </div> 

</div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>2025 &copy; SMKN 1 GARUT</p>
                    </div>
                    <div class="float-right">
                        <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by PPLG</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ url('/') }}/assets/js/feather-icons/feather.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ url('/') }}/assets/js/app.js"></script>
    <script src="{{ url('/') }}/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="{{ url('/') }}/assets/js/vendors.js"></script>
    
    <script src="{{ url('/') }}/assets/js/main.js"></script>
</body>
</html>
