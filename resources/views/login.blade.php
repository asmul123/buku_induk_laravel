<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Ulang CMB - SMKN 1 GARUT</title>
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/bootstrap.css">
    
    <link rel="shortcut icon" href="{{ url('/') }}/assets/images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ url('/') }}/assets/css/app.css">
</head>

<body>
    <div id="auth">
        
<div class="container">
    <div class="row">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="{{ url('/assets/images/logo.png') }}" height="120" class='mb-4'>
                        <h3>SMKN 1 GARUT</h3>
                        <p>Portal Daftar Ulang</p>
                        
                        @if (session('failed'))
                        <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                        @endif
                        
                    </div>

                    <form action="{{ url('/login') }}" method="post">
                        @csrf
                        <div class="form-group position-relative has-icon-left">
                            <label for="nomor_pendaftaran">Nomor Pendaftaran</label>
                            <div class="position-relative">
                                <input type="text" class="form-control" id="nomor_pendaftaran" name="nomor_pendaftaran" placeholder="20209201-0-00000">
                                <div class="form-control-icon">
                                    <i data-feather="user"></i>
                                </div>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left">
                            <div class="clearfix">
                                <label for="tanggal_lahir">Tanggal Lahir</label>
                            </div>
                            <div class="position-relative">
                                <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                <input type="hidden" name="password" value="Cimanuk309A">
                                <div class="form-control-icon">
                                    <i data-feather="calendar"></i>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix text-center mt-5">
                            <button class="btn btn-primary">Masuk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

    </div>
    <script src="{{ url('/') }}/assets/js/feather-icons/feather.min.js"></script>
    <script src="{{ url('/') }}/assets/js/app.js"></script>
    
    <script src="{{ url('/') }}/assets/js/main.js"></script>
</body>

</html>
