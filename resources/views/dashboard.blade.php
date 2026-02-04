@extends('layouts.main')

@section('content')
<div class="main-content container-fluid">
    <div class="page-title">
        <h3>Dashboard</h3>
        <p class="text-subtitle text-muted">Selamat datang di Aplikasi Buku Induk {{ $sekolah->nama ?? '' }}</p>
    </div>
    
    @if($semesterAktif)
    <div class="alert alert-light-info">
        <i class="bi bi-calendar-check"></i> Semester Aktif: <strong>{{ $semesterAktif->nama }}</strong>
    </div>
    @else
    <div class="alert alert-light-warning">
        <i class="bi bi-exclamation-triangle"></i> Belum ada semester aktif yang ditetapkan.
    </div>
    @endif

    <section class="section">
        <div class="row mb-2">
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <div>
                                    <h3 class='card-title'>SISWA AKTIF</h3>
                                    <div class='d-flex align-items-center'>
                                        <h4 class='card-title text-primary mb-0'>{{ number_format($jumlahSiswaAktif) }}</h4>
                                        <span class="text-muted ms-2">siswa</span>
                                    </div>
                                </div>
                                <div>
                                    <span class='card-icon bg-primary'>
                                        <i class='bi bi-people-fill text-white' style="font-size: 1.5rem;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper px-3 pb-2">
                                <div class="d-flex justify-content-between small text-muted">
                                    <span><i class="bi bi-gender-male text-primary"></i> L: {{ number_format($jumlahSiswaLaki) }}</span>
                                    <span><i class="bi bi-gender-female text-danger"></i> P: {{ number_format($jumlahSiswaPerempuan) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <div>
                                    <h3 class='card-title'>ROMBEL AKTIF</h3>
                                    <div class='d-flex align-items-center'>
                                        <h4 class='card-title text-success mb-0'>{{ number_format($jumlahRombelAktif) }}</h4>
                                        <span class="text-muted ms-2">rombel</span>
                                    </div>
                                </div>
                                <div>
                                    <span class='card-icon bg-success'>
                                        <i class='bi bi-collection-fill text-white' style="font-size: 1.5rem;"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <div>
                                    <h3 class='card-title'>NILAI TERINPUT</h3>
                                    <div class='d-flex align-items-center'>
                                        <h4 class='card-title text-warning mb-0'>{{ number_format($jumlahNilaiInput) }}</h4>
                                        <span class="text-muted ms-2">nilai</span>
                                    </div>
                                </div>
                                <div>
                                    <span class='card-icon bg-warning'>
                                        <i class='bi bi-journal-check text-white' style="font-size: 1.5rem;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper px-3 pb-2">
                                <div class="small text-muted">
                                    Semester {{ $semesterAktif->nama ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <div class="card card-statistic">
                    <div class="card-body p-0">
                        <div class="d-flex flex-column">
                            <div class='px-3 py-3 d-flex justify-content-between'>
                                <div>
                                    <h3 class='card-title'>TOTAL DATA SISWA</h3>
                                    <div class='d-flex align-items-center'>
                                        <h4 class='card-title text-info mb-0'>{{ number_format($totalPesertaDidik) }}</h4>
                                        <span class="text-muted ms-2">siswa</span>
                                    </div>
                                </div>
                                <div>
                                    <span class='card-icon bg-info'>
                                        <i class='bi bi-database-fill text-white' style="font-size: 1.5rem;"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="chart-wrapper px-3 pb-2">
                                <div class="small text-muted">
                                    Seluruh data tersimpan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-12 col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Perkembangan Jumlah Siswa per Tahun Pelajaran</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="chartSiswa" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Komposisi Siswa Aktif</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="chartKomposisi" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Menu Cepat</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ url('/indukrombel') }}" class="btn btn-outline-primary btn-block w-100 py-3">
                                    <i class="bi bi-book" style="font-size: 2rem;"></i><br>
                                    Buku Induk
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ url('/singkron') }}" class="btn btn-outline-success btn-block w-100 py-3">
                                    <i class="bi bi-arrow-repeat" style="font-size: 2rem;"></i><br>
                                    Sinkronisasi
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ url('/rombonganbelajar') }}" class="btn btn-outline-warning btn-block w-100 py-3">
                                    <i class="bi bi-collection" style="font-size: 2rem;"></i><br>
                                    Rombongan Belajar
                                </a>
                            </div>
                            <div class="col-md-3 col-6 mb-3">
                                <a href="{{ url('/kurikulum') }}" class="btn btn-outline-info btn-block w-100 py-3">
                                    <i class="bi bi-file-earmark-text" style="font-size: 2rem;"></i><br>
                                    Kurikulum
                                </a>
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
<script src="{{ url('/') }}/assets/vendors/chartjs/Chart.min.js"></script>
<script>
    // Data dari controller
    var chartLabels = @json($chartLabels);
    var chartValues = @json($chartValues);
    
    // Grafik Perkembangan Jumlah Siswa
    var ctxSiswa = document.getElementById('chartSiswa').getContext('2d');
    var chartSiswa = new Chart(ctxSiswa, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Jumlah Siswa',
                data: chartValues,
                backgroundColor: 'rgba(67, 94, 190, 0.8)',
                borderColor: 'rgba(67, 94, 190, 1)',
                borderWidth: 1,
                borderRadius: 5,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Jumlah: ' + context.parsed.y.toLocaleString() + ' siswa';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    
    // Grafik Komposisi Siswa (Pie Chart)
    var ctxKomposisi = document.getElementById('chartKomposisi').getContext('2d');
    var chartKomposisi = new Chart(ctxKomposisi, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $jumlahSiswaLaki }}, {{ $jumlahSiswaPerempuan }}],
                backgroundColor: [
                    'rgba(67, 94, 190, 0.8)',
                    'rgba(234, 84, 85, 0.8)'
                ],
                borderColor: [
                    'rgba(67, 94, 190, 1)',
                    'rgba(234, 84, 85, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var total = context.dataset.data.reduce((a, b) => a + b, 0);
                            var percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed.toLocaleString() + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });
</script>
@endsection