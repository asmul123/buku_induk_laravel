<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUKU INDUK - SMKN 3 GARUT</title>
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/choices.js/choices.min.css" />
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/chartjs/Chart.min.css">

    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/app.css">
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.ico" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    
    <link rel="stylesheet" href="{{ url('/') }}/assets/vendors/simple-datatables/style.css">
    <!-- include summernote css/js -->
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- place this script before closing body tag -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>

    @yield('modulhead')
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
    <div class="sidebar-header">
        <img src="{{ url('/') }}/assets/images/banner.svg" alt="" srcset="">
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class='sidebar-title'>Main Menu</li>
                <li class="sidebar-item {{ ($menu === 'dashboard') ? 'active' : '' }}">
                    <a href="{{ url('/') }}" class='sidebar-link'>
                        <i data-feather="home" width="20"></i> 
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="sidebar-item {{ ($menu === 'singkron') ? 'active' : '' }}">
                    <a href="{{ url('/singkron') }}" class='sidebar-link'>
                        <i data-feather="refresh-ccw" width="20"></i> 
                        <span>Singkronisasi</span>
                    </a>
                </li>
                <li class="sidebar-item  has-sub {{ ($menu === 'bukuinduk') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="list" width="20"></i> 
                        <span>Buku Induk</span>
                    </a>                    
                    <ul class="submenu {{ ($smenu === 'rombel') ? 'active' : '' }}">                        
                        <li>
                            <a href="{{ url('/indukrombel') }}">Per Rombel</a>
                        </li>
                        <li>
                            <a href="{{ url('/indukmurid') }}">Per Murid</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  has-sub {{ ($menu === 'referensi') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="list" width="20"></i> 
                        <span>Referensi</span>
                    </a>                    
                    <ul class="submenu {{ ($smenu === 'kurikulum') ? 'active' : '' }}">                        
                        <li>
                            <a href="{{ url('/kurikulum') }}">Data Kurikulum</a>
                        </li>
                        <li>
                            <a href="{{ url('/rombonganbelajar') }}">Data Rombongan Belajar</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item  has-sub {{ ($menu === 'pengaturan') ? 'active' : '' }}">
                    <a href="#" class='sidebar-link'>
                        <i data-feather="settings" width="20"></i> 
                        <span>Pengaturan</span>
                    </a>                    
                    <ul class="submenu {{ ($smenu === 'dapodik') ? 'active' : '' }}">                        
                        <li>
                            <a href="{{ url('/dapo') }}">Dapodik</a>
                        </li>
                        <li>
                            <a href="{{ url('/semester') }}">Semester Aktif</a>
                        </li>
                    </ul>
                </li>
                <li class="sidebar-item">
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
            @include('layouts.side')
            @yield('content')
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-left">
                        <p>{{ date('Y') }} &copy; SMKN 3 GARUT</p>
                    </div>
                    <div class="float-right">
                        <p>Crafted with <span class='text-danger'><i data-feather="heart"></i></span> by <a href="#">TRSMEA</a></p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    
    <script src="{{ url('/') }}/assets/js/feather-icons/feather.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="{{ url('/') }}/assets/js/app.js"></script>
    
    <script src="{{ url('/') }}/assets/vendors/chartjs/Chart.min.js"></script>
    <script src="{{ url('/') }}/assets/vendors/apexcharts/apexcharts.min.js"></script>
    <script src="{{ url('/') }}/assets/js/pages/dashboard.js"></script>
    
    
    <!-- Include Choices JavaScript -->
    <script src="{{ url('/') }}/assets/vendors/choices.js/choices.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="{{ url('/') }}/assets/js/main.js"></script>
    
    <script src="{{ url('/') }}/assets/vendors/simple-datatables/simple-datatables.js"></script>
    <script src="{{ url('/') }}/assets/js/vendors.js"></script>
    
    @yield('modulfoot')

</body>
</html>
