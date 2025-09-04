@extends('layouts.main')

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
                        
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pilih Tahun Pelajaran</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" id="semester_id" name="semester_id">
                                                <option value="{{ url('/indukrombel') }}">Pilih Tahun Pelajaran</option>                                                
                                                @foreach($tapels as $tapel)
                                                <option value="{{ url('/indukrombel/?sem_id=').$tapel->id }}" @if($tapel->id == $sem_id) selected @endif>{{ $tapel->nama }}</option> 
                                                @endforeach                                               
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @if($sem_id<>"")
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Pilih Rombongan Belajar</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form>
                                        <div class="form-group">
                                            <select class="form-control form-control-sm" id="rombel_id" name="semester_id">
                                                <option value="{{ url('/indukrombel?sem_id='.$sem_id) }}">Pilih Rombongan Belajar</option>  
                                                @foreach($rombels as $rombel)                                              
                                                <option value="{{ url('/indukrombel?sem_id='.$sem_id.'&rom_id='.$rombel->id) }}" @if($rombel->id == $rom_id) selected @endif>{{ $rombel->nama }}</option>   
                                                @endforeach                                             
                                            </select>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>                    
                </div>
                        @if($rom_id<>"")
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Foto</th>
                                    <th>NIM</th>
                                    <th>NISN</th>
                                    <th>Nama Murid</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($anggotarombels as $anggotarombel)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td></td>
                                    <td>{{ $anggotarombel->no_induk }}</td>
                                    <td>{{ $anggotarombel->nisn }}</td>
                                    <td>{{ $anggotarombel->nama }}</td>
                                    <td>{{ $anggotarombel->jenis_kelamin }}</td>
                                    <td><a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#lihatPembelajaran" id="btn-lihat-pembelajaran" data-id="{{ $anggotarombel->id }}">Lihat</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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