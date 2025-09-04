@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Referensi Kurikulum</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                <h4 class="card-title">Data Kurikulum</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Kurikulum</th>
                                    <th>Mulai Berlaku</th>
                                    <th>Sistem SKS</th>
                                    <th>Total SKS</th>
                                    <th>Jenjang Pendidikan</th>
                                    <th>Jurusan</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($kurikulums as $kurikulum)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $kurikulum->nama_kurikulum }}</td>
                                    <td>{{ $kurikulum->mulai_berlaku }}</td>
                                    <td>{{ $kurikulum->sistem_sks }}</td>
                                    <td>{{ $kurikulum->total_sks }}</td>
                                    <td>{{ $kurikulum->jenjangpendidikan->jenjang_pendidikan }}</td>
                                    <td>{{ $kurikulum->jurusan->nama_jurusan }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

    
@endsection