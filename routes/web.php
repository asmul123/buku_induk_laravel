<?php

use App\Http\Controllers\AnggotarombelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DapoController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SingkronController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\RombonganbelajarController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\IndukrombelController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware('auth');
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/dapo', [DapoController::class, 'index'])->name('dapo')->middleware('auth');
Route::get('/singkron-sekolah', [SingkronController::class, 'sekolah'])->name('sekolah')->middleware('auth');
Route::get('/singkron-ptk', [SingkronController::class, 'ptk'])->name('ptk')->middleware('auth');
Route::get('/singkron-pd', [SingkronController::class, 'pd'])->name('pd')->middleware('auth');
Route::get('/singkron-rombel', [SingkronController::class, 'rombel'])->name('rombel')->middleware('auth');
Route::post('/dapo', [DapoController::class, 'update'])->name('dapo')->middleware('auth');
Route::get('/singkron', [SingkronController::class, 'index'])->middleware('auth');
Route::get('/indukrombel', [IndukrombelController::class, 'index'])->middleware('auth');
Route::get('/indukmurid', [IndukrombelController::class, 'indukmurid'])->middleware('auth');
Route::get('/detailmurid', [IndukrombelController::class, 'detail'])->middleware('auth');
Route::get('/editmurid', [IndukrombelController::class, 'edit'])->middleware('auth');
Route::get('/editnilai', [IndukrombelController::class, 'editnilai'])->middleware('auth');
Route::get('/editabsensi', [IndukrombelController::class, 'editAbsensi'])->middleware('auth');
Route::get('/editkenaikan', [IndukrombelController::class, 'editKenaikan'])->middleware('auth');
Route::get('/cetak', [IndukrombelController::class, 'cetak'])->middleware('auth');
Route::get('/get-kelompok', [IndukrombelController::class, 'getKelompok'])->middleware('auth');
Route::get('/get-matapelajaran', [IndukrombelController::class, 'getMatapelajaran'])->middleware('auth');
Route::post('/tambah-mapel', [IndukrombelController::class, 'tambahMapel'])->middleware('auth');
Route::post('/upload', [IndukrombelController::class, 'upload'])->middleware('auth');
Route::post('/simpan-absensi', [IndukrombelController::class, 'simpanAbsensi'])->middleware('auth');
Route::post('/simpan-kenaikan', [IndukrombelController::class, 'simpanKenaikan'])->middleware('auth');
Route::get('/login', [LoginController::class, 'admin'])->name('login')->middleware('guest');
Route::get('/admin', [LoginController::class, 'admin'])->name('admin')->middleware('guest');
Route::post('/updateinduk', [IndukrombelController::class, 'updateinduk'])->middleware('auth');
Route::post('/login', [LoginController::class, 'admin']);
Route::post('/admin', [LoginController::class, 'authadmin']);
Route::post('/logout', [LoginController::class, 'logout']);


// Akun Routes
Route::get('/akun', [UserController::class, 'ubahpassword'])->middleware('auth');
Route::post('/akun', [UserController::class, 'passwordupdate'])->middleware('auth');
Route::post('/akun/profile', [UserController::class, 'updateProfile'])->middleware('auth');
Route::post('/akun/photo', [UserController::class, 'updatePhoto'])->middleware('auth');

// Semester Routes
Route::get('/semester', [SemesterController::class, 'index'])->middleware('auth');
Route::post('/semester', [SemesterController::class, 'store'])->middleware('auth');
Route::post('/semester/set-aktif/{id}', [SemesterController::class, 'setAktif'])->middleware('auth');
Route::delete('/semester/{id}', [SemesterController::class, 'destroy'])->middleware('auth');

Route::resource('/kurikulum', KurikulumController::class)->middleware('auth');
Route::resource('/rombonganbelajar', RombonganbelajarController::class)->middleware('auth');
Route::resource('/pembelajaran', PembelajaranController::class)->middleware('auth');
Route::resource('/anggotarombel', AnggotarombelController::class)->middleware('auth');