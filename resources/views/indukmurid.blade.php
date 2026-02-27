@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                <h4 class="card-title">Data Buku Induk Per Murid</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pilih Tahun Ajaran (Angkatan)</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" id="angkatan_id" name="angkatan_id">
                                                <option value="{{ url('/indukmurid') }}">Pilih Tahun Ajaran (Angkatan)</option>                                                
                                                @foreach($angkatans as $angkatan)
                                                <option value="{{ url('/indukmurid/?angkatan_id=').$angkatan->tahunajaran_id }}" @if($angkatan->tahunajaran_id == $angkatan_id) selected @endif>{{ $angkatan->tahunajaran_id }}/{{ $angkatan->tahunajaran_id + 1 }}</option> 
                                                @endforeach                                               
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>                    
                </div>
                        @if($angkatan_id <> "")
                        <div class="alert alert-info">
                            <strong>Info:</strong> Data diurutkan berdasarkan Nomor Induk. Menampilkan siswa angkatan {{ $angkatan_id }}/{{ $angkatan_id + 1 }}.
                            @if($pesertadidiks != "" && $pesertadidiks->count() > 0)
                                Total: <strong>{{ $pesertadidiks->count() }}</strong> siswa.
                            @endif
                        </div>
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>No. Induk</th>
                                    <th>NISN</th>
                                    <th>Nama Murid</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Tempat, Tgl Lahir</th>
                                    <th>Rombel Terakhir</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if($pesertadidiks != "")
                            @foreach($pesertadidiks as $murid)
                                @php
                                    // Ambil rombel terakhir reguler berdasarkan semester terbaru
                                    $latestRombel = $murid->Anggotarombel()
                                        ->with('Rombonganbelajar.jenisrombel')
                                        ->whereHas('Rombonganbelajar', function($q) {
                                            $q->where('jenisrombel_id', 1); // jenisrombel reguler biasanya id 1
                                        })
                                        ->orderBy('semester_id', 'desc')
                                        ->first();
                                    
                                    // Tentukan status berdasarkan tanggal_meninggalkan dan tanggal_ijazah_akhir
                                    $status = 'Aktif';
                                    if($murid->tanggal_meninggalkan) {
                                        $status = 'Keluar';
                                    } elseif($murid->tanggal_ijazah_akhir) {
                                        $status = 'Lulus';
                                    }
                                @endphp
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td><img src="{{ $murid->photo == null ? url('assets/images/avatar/no_image.jpg') : url('storage/'.$murid->photo) }}" width="50px"></td>
                                    <td>{{ $murid->no_induk }}</td>
                                    <td>{{ $murid->nisn }}</td>
                                    <td>{{ $murid->nama }}</td>
                                    <td>{{ $murid->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                                    <td>{{ $murid->tempat_lahir }}, {{ date('d-m-Y', strtotime($murid->tanggal_lahir)) }}</td>
                                    <td>{{ $latestRombel?->Rombonganbelajar?->nama ?? '-' }}</td>
                                    <td>
                                        @if($status == 'Aktif')
                                            <span class="badge bg-success">{{ $status }}</span>
                                        @elseif($status == 'Lulus')
                                            <span class="badge bg-info">{{ $status }}</span>
                                        @else
                                            <span class="badge bg-warning">{{ $status }}</span>
                                        @endif
                                    </td>
                                    <td><a href="{{ url('/detailmurid?pd_id='.$murid->id) }}" class="btn btn-success btn-sm">Lihat</a></td>
                                </tr>
                            @endforeach
                            @endif
                            </tbody>
                        </table>
                        @if($pesertadidiks == "" || $pesertadidiks->count() == 0)
                        <div class="alert alert-warning">
                            <strong>Tidak ada data!</strong> Tidak ditemukan siswa pada angkatan {{ $angkatan_id }}/{{ $angkatan_id + 1 }}.
                        </div>
                        @endif
                        @endif                        
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
        $('#angkatan_id').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>
@endsection
