@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Akun</h3>
        <p class="text-subtitle text-muted">Kelola Akun Pengguna</p>
    </div>
    <section class="section">
        <div class="row">
            <!-- Foto Profil -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Foto Profil</h4>
                    </div>
                    <div class="card-body text-center">
                        @if (session('success_photo'))
                        <div class="alert alert-light-success color-success">{{ session('success_photo') }}</div>
                        @endif
                        
                        <div class="mb-3">
                            @if(Auth::user()->photo)
                                <img src="{{ url('/storage/photos/' . Auth::user()->photo) }}" 
                                     alt="Foto Profil" 
                                     class="rounded-circle img-thumbnail" 
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     id="preview-photo">
                            @else
                                <img src="{{ url('/') }}/assets/images/faces/1.jpg" 
                                     alt="Foto Default" 
                                     class="rounded-circle img-thumbnail" 
                                     style="width: 150px; height: 150px; object-fit: cover;"
                                     id="preview-photo">
                            @endif
                        </div>
                        <p class="text-muted mb-3">{{ Auth::user()->name }}</p>
                        
                        <form action="{{ url('/akun/photo') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <input type="file" 
                                       name="photo" 
                                       class="form-control" 
                                       id="input-photo"
                                       accept="image/jpeg,image/png,image/jpg,image/gif"
                                       onchange="previewImage(this)">
                                <small class="text-muted">Format: JPG, PNG, GIF. Max: 2MB</small>
                            </div>
                            @error('photo')
                            <div class="text-danger mb-2">{{ $message }}</div>
                            @enderror
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <i class="bi bi-upload"></i> Upload Foto
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="col-md-8">
                <!-- Edit Profil -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h4 class="card-title">Edit Profil</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success_profile'))
                        <div class="alert alert-light-success color-success">{{ session('success_profile') }}</div>
                        @endif
                        @if (session('failed'))
                        <div class="alert alert-light-danger color-danger">{{ session('failed') }}</div>
                        @endif
                        
                        <form action="{{ url('/akun/profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Nama Lengkap</label>
                                <input type="text" 
                                       name="name" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       value="{{ old('name', Auth::user()->name) }}"
                                       placeholder="Nama Lengkap">
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email / Username</label>
                                <input type="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       value="{{ old('email', Auth::user()->email) }}"
                                       placeholder="Email / Username">
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="clearfix">
                                <button type="submit" class="btn btn-primary float-end">
                                    <i class="bi bi-save"></i> Simpan Profil
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Ganti Kata Sandi -->
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Ganti Kata Sandi</h4>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-light-success color-success">{{ session('success') }}</div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-light-danger color-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                <li class="text-danger">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        
                        <form action="{{ url('/akun') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="current_password">Kata Sandi Saat Ini</label>
                                <input type="password" 
                                       name="current_password" 
                                       class="form-control" 
                                       id="current_password" 
                                       placeholder="Masukkan kata sandi saat ini">
                            </div>
                            <div class="form-group">
                                <label for="password">Kata Sandi Baru</label>
                                <input type="password" 
                                       name="password" 
                                       class="form-control" 
                                       id="password" 
                                       placeholder="Masukkan kata sandi baru">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
                                <input type="password" 
                                       name="password_confirmation" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       placeholder="Konfirmasi kata sandi baru">
                            </div>
                            <div class="clearfix">
                                <button type="submit" class="btn btn-warning float-end">
                                    <i class="bi bi-key"></i> Ganti Kata Sandi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
function previewImage(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-photo').src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}
</script>

@endsection