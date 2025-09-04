@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Singkron</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                Ambil data DAPODIK
            </div>
            <div class="card-body">                
                @if (session('success'))
                <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                @endif
                
                @if (session('failed'))
                <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                @endif
                <table class='table table-striped' id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Data</th>
                            <th>JML Data Aplikasi</th>
                            <th>JML Data Dapodik</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Sekolah</td>
                            <td>{{ $skldbcount }}</td>
                            <td>{{ $sklcount }}</td>
                            <td>
                                @if($skldbcount < $sklcount)
                                <span class="badge bg-danger">Kurang</span>
                                @elseif($skldbcount > $sklcount)
                                <span class="badge bg-warning">Lebih</span>
                                @else
                                <span class="badge bg-success">Lengkap</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/singkron-sekolah') }}" class="badge bg-success">Singkron</a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>PTK</td>
                            <td>{{ $ptkdbcount }}</td>
                            <td>{{ $ptkcount }}</td>
                            <td>
                                @if($ptkdbcount < $ptkcount)
                                <span class="badge bg-danger">Kurang</span>
                                @elseif($ptkdbcount > $ptkcount)
                                <span class="badge bg-warning">Lebih</span>
                                @else
                                <span class="badge bg-success">Lengkap</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/singkron-ptk') }}" class="badge bg-success">Singkron</a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Peserta Didik</td>
                            <td>{{ $pddbcount }}</td>
                            <td>{{ $pdcount }}</td>
                            <td>
                                @if($pddbcount < $pdcount)
                                <span class="badge bg-danger">Kurang</span>
                                @elseif($pddbcount > $pdcount)
                                <span class="badge bg-warning">Lebih</span>
                                @else
                                <span class="badge bg-success">Lengkap</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/singkron-pd') }}" class="badge bg-success">Singkron</a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>Rombongan Belajar</td>
                            <td>{{ $rombeldbcount }}</td>
                            <td>{{ $rombelcount }}</td>
                            <td>
                                @if($rombeldbcount < $rombelcount)
                                <span class="badge bg-danger">Kurang</span>
                                @elseif($rombeldbcount > $rombelcount)
                                <span class="badge bg-warning">Lebih</span>
                                @else
                                <span class="badge bg-success">Lengkap</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ url('/singkron-rombel') }}" class="badge bg-success">Singkron</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </section>
</div>

    
@endsection