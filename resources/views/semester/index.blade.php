@extends('layouts.main')

@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Pengaturan Semester</h3>
                <p class="text-subtitle text-muted">Kelola semester dan atur semester aktif</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class='breadcrumb-header'>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Semester</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-light-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-light-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Semester Aktif Saat Ini</h4>
                    </div>
                    <div class="card-body">
                        @if($semesterAktif)
                        <div class="alert alert-light-success">
                            <h5 class="alert-heading"><i class="bi bi-check-circle-fill"></i> {{ $semesterAktif->nama }}</h5>
                            <hr>
                            <p class="mb-1"><strong>ID:</strong> {{ $semesterAktif->id }}</p>
                            <p class="mb-1"><strong>Tahun Ajaran:</strong> {{ $semesterAktif->tahunajaran_id }}/{{ $semesterAktif->tahunajaran_id + 1 }}</p>
                            <p class="mb-1"><strong>Semester:</strong> {{ $semesterAktif->semester == 1 ? 'Ganjil' : 'Genap' }}</p>
                            <p class="mb-1"><strong>Mulai:</strong> {{ date('d F Y', strtotime($semesterAktif->tanggal_mulai)) }}</p>
                            <p class="mb-0"><strong>Selesai:</strong> {{ date('d F Y', strtotime($semesterAktif->tanggal_selesai)) }}</p>
                        </div>
                        @else
                        <div class="alert alert-light-warning">
                            <i class="bi bi-exclamation-triangle"></i> Belum ada semester aktif
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Tambah Semester Baru</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/semester') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="tahunajaran_id">Tahun Ajaran</label>
                                <input type="number" name="tahunajaran_id" id="tahunajaran_id" class="form-control @error('tahunajaran_id') is-invalid @enderror" placeholder="Contoh: 2025" required min="2000" max="2100" value="{{ old('tahunajaran_id') }}">
                                <small class="text-muted">Masukkan tahun awal (contoh: 2025 untuk TA 2025/2026)</small>
                                @error('tahunajaran_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="semester">Semester</label>
                                <select name="semester" id="semester" class="form-control @error('semester') is-invalid @enderror" required>
                                    <option value="">-- Pilih Semester --</option>
                                    <option value="1" {{ old('semester') == '1' ? 'selected' : '' }}>Ganjil</option>
                                    <option value="2" {{ old('semester') == '2' ? 'selected' : '' }}>Genap</option>
                                </select>
                                @error('semester')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="id">ID Semester</label>
                                <input type="text" name="id" id="id" class="form-control @error('id') is-invalid @enderror" placeholder="Contoh: 20251" readonly value="{{ old('id') }}">
                                <small class="text-muted">ID otomatis: TahunAjaran + Semester</small>
                                @error('id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="nama">Nama Semester</label>
                                <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Contoh: 2025/2026 Ganjil" readonly value="{{ old('nama') }}">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_mulai">Tanggal Mulai</label>
                                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control @error('tanggal_mulai') is-invalid @enderror" required value="{{ old('tanggal_mulai') }}">
                                @error('tanggal_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="tanggal_selesai">Tanggal Selesai</label>
                                <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="form-control @error('tanggal_selesai') is-invalid @enderror" required value="{{ old('tanggal_selesai') }}">
                                @error('tanggal_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    <i class="bi bi-plus-circle"></i> Tambah Semester
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Daftar Semester</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama Semester</th>
                                        <th>Periode</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($semesters as $semester)
                                    <tr>
                                        <td>{{ $semester->id }}</td>
                                        <td>{{ $semester->nama }}</td>
                                        <td>
                                            {{ date('d/m/Y', strtotime($semester->tanggal_mulai)) }} - 
                                            {{ date('d/m/Y', strtotime($semester->tanggal_selesai)) }}
                                        </td>
                                        <td>
                                            @if($semester->periode_aktif == 1)
                                            <span class="badge bg-success">Aktif</span>
                                            @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($semester->periode_aktif != 1)
                                            <form action="{{ url('/semester/set-aktif/'.$semester->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin mengaktifkan semester ini?')">
                                                    <i class="bi bi-check-circle"></i> Set Aktif
                                                </button>
                                            </form>
                                            <form action="{{ url('/semester/'.$semester->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus semester ini?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <span class="text-success"><i class="bi bi-check-circle-fill"></i> Sedang Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data semester</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $semesters->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('modulfoot')
<script>
    // Auto generate ID dan Nama berdasarkan Tahun Ajaran dan Semester
    function generateIdNama() {
        var tahun = document.getElementById('tahunajaran_id').value;
        var sem = document.getElementById('semester').value;
        
        if (tahun && sem) {
            var id = tahun + sem;
            var tahunAkhir = parseInt(tahun) + 1;
            var semNama = sem == '1' ? 'Ganjil' : 'Genap';
            var nama = tahun + '/' + tahunAkhir + ' ' + semNama;
            
            document.getElementById('id').value = id;
            document.getElementById('nama').value = nama;
        }
    }
    
    document.getElementById('tahunajaran_id').addEventListener('change', generateIdNama);
    document.getElementById('tahunajaran_id').addEventListener('keyup', generateIdNama);
    document.getElementById('semester').addEventListener('change', generateIdNama);
</script>
@endsection
