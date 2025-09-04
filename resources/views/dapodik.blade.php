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

    
@endsection