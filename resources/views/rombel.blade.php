@extends('layouts.main')

@section('modulhead')
<style>
  #loadingOverlay {
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    z-index: 2000; /* di atas modal bootstrap */
    display: flex;
    justify-content: center;
    align-items: center;
    flex-direction: column;
  }
</style>
@endsection
@section('content')


<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Referensi Rombongan Belajar</h3>
    </div>
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Pilih Tahun Pelajaran</h4>
            </div>
            <div class="card-body">
                <div class="basic-form">
                    <form>
                        <div class="form-group">
                            <select class="form-control form-control-sm" id="semester_id" name="semester_id">
                                <option value="{{ url('/rombonganbelajar') }}">Pilih Tahun Pelajaran</option>                                                
                                @foreach($tapels as $tapel)
                                <option value="{{ url('/rombonganbelajar/?sem_id=').$tapel->id }}" @if($tapel->id == $sem_id) selected @endif>{{ $tapel->nama }}</option> 
                                @endforeach                                               
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="card-header">
                <h4 class="card-title">Data Rombongan Belajar</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <table class='table table-striped' id="table1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Rombel</th>
                                    <th>Wali Kelas</th>
                                    <th>Jenis Rombel</th>
                                    <th>Jumlah Murid</th>
                                    <th>Pembelajaran</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($rombonganbelajars as $rombonganbelajar)
                                <tr>
                                    <td>{{ $no++ }}</td>
                                    <td>{{ $rombonganbelajar->nama }}</td>
                                    <td>
                                        @php
                                            $ptk = App\Models\Ptk::where('id', $rombonganbelajar->ptk_id)->count();
                                        @endphp
                                        @if($ptk<>0)
                                        {{ $rombonganbelajar->ptk->nama }}
                                        @else
                                        -
                                        @endif
                                    </td>
                                    <td>{{ $rombonganbelajar->jenisrombel->jenis_rombel }}</td>
                                    <td><a href="javascript:void(0)" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#lihatAnggota" id="btn-lihat-anggota" data-id="{{ $rombonganbelajar->id }}">{{ App\Models\Anggotarombel::where('rombonganbelajar_id', $rombonganbelajar->id)->count() }}</a></td>
                                    <td><a href="javascript:void(0)" class="btn btn-success btn-sm" data-toggle="modal" data-target="#lihatPembelajaran" id="btn-lihat-pembelajaran" data-id="{{ $rombonganbelajar->id }}">Lihat</a></td>
                                    <td></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <!-- Lihat Anggota -->
                        <div class="modal fade text-left w-100" id="lihatAnggota" tabindex="-1" role="dialog"
                        aria-labelledby="myModalLabel16" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel16">Daftar Anggota Rombel</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <div id="daftar-anggota">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Tutup</span>
                                    </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Lihat Pembelajaran -->
                        <form action="{{ url('/rombonganbelajar') }}" method="POST" id="myForm">
                            @csrf
                            <div class="modal fade text-left w-100" id="lihatPembelajaran" tabindex="-1" role="dialog"
                            aria-labelledby="myModalLabel16" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel16">Daftar Pembelajaran</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i data-feather="x"></i>
                                        </button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="daftar-pembelajaran">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                        <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
                                            <i class="bx bx-x d-block d-sm-none"></i>
                                            <span class="d-none d-sm-block">Tutup</span>
                                        </button>
                                        <button type="submit" id="btnSubmit" class="btn btn-primary">
                                                    <span id="btnText">Simpan</span>
                                                </button>
                                        </div>                                    
                                        <!-- Overlay Spinner -->
                                        <div id="loadingOverlay" class="d-none">
                                        <div class="overlay-content">
                                            <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
                                            <p class="mt-3 text-white">Sedang memproses...</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Modal Success -->
                        <div class="modal fade" id="successModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-4">
                                        <h5 class="mb-3">Berhasil!</h5>
                                        <p id="pesan">Data berhasil disimpan.</p>
                                        <button type="button" class="btn btn-light mt-2" data-bs-dismiss="modal">OK</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi -->
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="{{ url('/pembelajaran') }}" method="POST" id="confirmForm">
                                        @method('delete')
                                        @csrf
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin akan menghapus Pembelajaran ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn">Ya, Hapus</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Konfirmasi 2 -->
                        <div class="modal fade" id="confirmDeleteModal2" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <form action="#" method="POST" id="confirmForm2">
                                        @method('delete')
                                        @csrf
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title">Konfirmasi Hapus</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin akan mengeluarkan Anggota ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-danger" id="confirmDeleteBtn2">Ya, Hapus</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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
    $('body').on('click', '#btn-lihat-anggota', function () {
                let rombel_id = $(this).data('id');
                
                //fetch detail post with ajax
                $.ajax({
                    url: "{{ url('/rombonganbelajar') }}/"+rombel_id+"?aksi=anggota",
                    type: "GET",
                    cache: false,
                    success:function(response){
                        //fill data to form
                        
                        // quilledit.clipboard.dangerouslyPasteHTML(response.data.diskusi);
                        $('#daftar-anggota').html(response);
                    }
                });
        });

    $('body').on('click', '#btn-lihat-pembelajaran', function () {
                let rombel_id = $(this).data('id');
                
                //fetch detail post with ajax
                $.ajax({
                    url: "{{ url('/rombonganbelajar') }}/"+rombel_id+"?aksi=pembelajaran",
                    type: "GET",
                    cache: false,
                    success:function(response){
                        //fill data to form
                        
                        // quilledit.clipboard.dangerouslyPasteHTML(response.data.diskusi);
                        $('#daftar-pembelajaran').html(response);
                    }
                });
        });
        

    $('body').on('click', '#btn-lihat-pembelajaran', function () {
                let rombel_id = $(this).data('id');
                
                //fetch detail post with ajax
                $.ajax({
                    url: "{{ url('/rombonganbelajar') }}/"+rombel_id+"?aksi=pembelajaran",
                    type: "GET",
                    cache: false,
                    success:function(response){
                        //fill data to form
                        
                        // quilledit.clipboard.dangerouslyPasteHTML(response.data.diskusi);
                        $('#daftar-pembelajaran').html(response);
                    }
                });
        });

    $('body').on('click', '#btn-hapus-pembelajaran', function () {
                let pembelajaran_id = $(this).data('id');
                
                // tampilkan modal konfirmasi
                let modal = new bootstrap.Modal(document.getElementById("confirmDeleteModal"));
                modal.show();
                
                // Saat user konfirmasi hapus
                document.getElementById("confirmDeleteBtn").addEventListener("click", function() {
                    if (pembelajaran_id) {
                        // --- Aksi 1: redirect sederhana ---
                        // window.location.href = "/hapus-pembelajaran/" + pembelajaran_id;

                        // --- Aksi 2: AJAX (contoh di-comment) ---
                        
                        // fetch("{{ url('/hapus-pembelajaran/') }}" + pembelajaran_id, {
                        //     method: "DELETE",
                        //     headers: {
                        //         "X-CSRF-TOKEN": "{{ csrf_token() }}",
                        //     }
                        // })
                        // .then(res => res.json())
                        // .then(data => {
                        //     alert("Pembelajaran berhasil dihapus!");
                        //     location.reload();
                        // })
                        // .catch(err => {
                        //     alert("Terjadi kesalahan: " + err);
                        // });
                        
                        $("#confirmForm").on("submit", function (e) {
                            e.preventDefault();

                            let form = $(this);
                            let url = form.attr("action")+"/"+pembelajaran_id;
                            let data = form.serialize();

                            // Tampilkan overlay spinner
                            $("#loadingOverlay").removeClass("d-none");

                            $.ajax({
                                url: url,
                                type: "POST",
                                data: data,
                                success: function (response) {
                                    // Update isi modal
                                    $("#daftar-pembelajaran").html(response);

                                    // Reset form
                                    form[0].reset();

                                    // Tampilkan modal success
                                    document.getElementById('pesan').innerText = "Berhasil menghapus Data";
                                    let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                    successModal.show();
                                },
                                error: function () {
                                    alert("Gagal Menghapus");
                                },
                                complete: function () {
                                    // Sembunyikan overlay spinner
                                    $("#loadingOverlay").addClass("d-none");
                                    let confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal'));
                                    confirmModal.hide();
                                }
                            });
                        });
                    }
                });
        });

    $('body').on('click', '#btn-hapus-anggota', function () {
                let anggota_id = $(this).data('id');
                
                // tampilkan modal konfirmasi
                let modal = new bootstrap.Modal(document.getElementById("confirmDeleteModal2"));
                modal.show();
                
                // Saat user konfirmasi hapus
                document.getElementById("confirmDeleteBtn2").addEventListener("click", function() {
                    if (anggota_id) {
                        
                        $("#confirmForm2").on("submit", function (e) {
                            e.preventDefault();

                            let form = $(this);
                            let url = "{{ url('/anggotarombel') }}/"+anggota_id;
                            let data = form.serialize();

                            // Tampilkan overlay spinner
                            $("#loadingOverlay").removeClass("d-none");

                            $.ajax({
                                url: url,
                                type: "POST",
                                data: data,
                                success: function (response) {
                                    // Update isi modal
                                    $("#daftar-anggota").html(response);

                                    // Reset form
                                    form[0].reset();

                                    // Tampilkan modal success
                                    document.getElementById('pesan').innerText = "Berhasil mengeluarkan Murid";
                                    let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                                    successModal.show();
                                },
                                error: function () {
                                    alert("Gagal mengeluarkan Murid"+url);
                                },
                                complete: function () {
                                    // Sembunyikan overlay spinner
                                    $("#loadingOverlay").addClass("d-none");
                                    let confirmModal = bootstrap.Modal.getInstance(document.getElementById('confirmDeleteModal2'));
                                    confirmModal.hide();
                                }
                            });
                        });
                    }
                });
        });
        
        
    $("#myForm").on("submit", function (e) {
        e.preventDefault();

        let form = $(this);
        let url = form.attr("action");
        let data = form.serialize();

        // Tampilkan overlay spinner
        $("#loadingOverlay").removeClass("d-none");

        $.ajax({
            url: url,
            type: "POST",
            data: data,
            success: function (response) {
                // Update isi modal
                $("#daftar-pembelajaran").html(response);

                // Reset form
                form[0].reset();

                // Tampilkan modal success
                document.getElementById('pesan').innerText = "Berhasil menyimpan Data";
                let successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            },
            error: function () {
                alert("Terjadi kesalahan, coba lagi.");
            },
            complete: function () {
                // Sembunyikan overlay spinner
                $("#loadingOverlay").addClass("d-none");
            }
        });
    });

    $('#successModal').on('hidden.bs.modal', function () {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open'); 
        }
    });

    $('#confirmDeleteModal').on('hidden.bs.modal', function () {
    if ($('.modal.show').length > 0) {
        $('body').addClass('modal-open'); 
        }
    });

    $(function() {
        // bind change event to select
        $('#semester_id').on('change', function() {
            var url = $(this).val(); // get selected value
            if (url) { // require a URL
                window.location = url; // redirect
            }
            return false;
        });
    });
</script>
@endsection