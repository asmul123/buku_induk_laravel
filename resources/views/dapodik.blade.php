@extends('layouts.main')

@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Pengaturan Dapodik</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                <h4 class="card-title">Atur Koneksi Dapodik</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <form class="form form-vertical" action="{{ url('/dapo') }}" method="POST">
                                <div class="col-12">    
                                    @csrf                               
                
                                    @if (session('success'))
                                    <div class="alert alert-light-success color-warning">{{ session('success') }}</div>
                                    @endif
                                    
                                    @if (session('failed'))
                                    <div class="alert alert-light-danger color-warning">{{ session('failed') }}</div>
                                    @endif
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">IP Address</label>
                                        <div class="position-relative">
                                            <input type="text" name="address" class="form-control" placeholder="172.0.0.1" id="first-name-icon" value="{{ $dapodik->address }}" autofocus>
                                            <div class="form-control-icon">
                                                <i data-feather="link"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">NPSN</label>
                                        <div class="position-relative">
                                            <input type="text" name="npsn" class="form-control" placeholder="xxxxxxxx" id="first-name-icon" value="{{ $dapodik->npsn }}">
                                            <div class="form-control-icon">
                                                <i data-feather="home"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group has-icon-left">
                                        <label for="first-name-icon">Token</label>
                                        <div class="position-relative">
                                            <input type="text" name="token" class="form-control" placeholder="xxxxxxx" id="first-name-icon" value="{{ $dapodik->token }}">
                                            <div class="form-control-icon">
                                                <i data-feather="lock"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary mr-1 mb-1">Simpan</button>                               
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal Error Dapodik -->
<div class="modal fade" id="modalErrorDapodik" tabindex="-1" role="dialog" aria-labelledby="modalErrorDapodikLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h5 class="modal-title text-white" id="modalErrorDapodikLabel">
                    <i class="fa fa-exclamation-triangle"></i> Peringatan
                </h5>
            </div>
            <div class="modal-body text-center">
                <div class="mb-3">
                    <i class="fa fa-times-circle text-danger" style="font-size: 60px;"></i>
                </div>
                <h5 class="mb-3">Koneksi Dapodik Gagal!</h5>
                <p class="text-muted">{{ session('error') ?? 'Harap lakukan pengaturan Dapodik dengan benar sebelum melakukan sinkronisasi data.' }}</p>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-primary" data-dismiss="modal">
                    <i class="fa fa-cog"></i> Atur Sekarang
                </button>
            </div>
        </div>
    </div>
</div>
    
@endsection

@section('modulfoot')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        @if(session('error'))
            $('#modalErrorDapodik').modal('show');
        @endif
    });
</script>
@endsection