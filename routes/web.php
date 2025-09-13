<?php

use App\Http\Controllers\AnggotarombelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DapoController;
use App\Http\Controllers\SingkronController;
use App\Http\Controllers\KurikulumController;
use App\Http\Controllers\RombonganbelajarController;
use App\Http\Controllers\PembelajaranController;
use App\Http\Controllers\IndukrombelController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/indukrombel');
});


Route::get('/dapo', [DapoController::class, 'index'])->name('dapo')->middleware('auth');
Route::get('/singkron-sekolah', [SingkronController::class, 'sekolah'])->name('sekolah')->middleware('auth');
Route::get('/singkron-ptk', [SingkronController::class, 'ptk'])->name('ptk')->middleware('auth');
Route::get('/singkron-pd', [SingkronController::class, 'pd'])->name('pd')->middleware('auth');
Route::get('/singkron-rombel', [SingkronController::class, 'rombel'])->name('rombel')->middleware('auth');
Route::post('/dapo', [DapoController::class, 'update'])->name('dapo')->middleware('auth');
Route::get('/singkron', [SingkronController::class, 'index'])->middleware('auth');
Route::get('/indukrombel', [IndukrombelController::class, 'index'])->middleware('auth');
Route::get('/detailmurid', [IndukrombelController::class, 'detail'])->middleware('auth');
Route::get('/cetak', [IndukrombelController::class, 'cetak'])->middleware('auth');
Route::get('/review', [IndukrombelController::class, 'review'])->middleware('auth');
Route::post('/upload', [IndukrombelController::class, 'upload'])->middleware('auth');
Route::get('/login', [LoginController::class, 'admin'])->name('login')->middleware('guest');
Route::get('/admin', [LoginController::class, 'admin'])->name('admin')->middleware('guest');
Route::post('/login', [LoginController::class, 'admin']);
Route::post('/admin', [LoginController::class, 'authadmin']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::resource('/kurikulum', KurikulumController::class)->middleware('auth');
Route::resource('/rombonganbelajar', RombonganbelajarController::class)->middleware('auth');
Route::resource('/pembelajaran', PembelajaranController::class)->middleware('auth');
Route::resource('/anggotarombel', AnggotarombelController::class)->middleware('auth');