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
    return redirect('/admin');
});


Route::get('/dapo', [DapoController::class, 'index'])->name('dapo')->middleware('guest');
Route::get('/singkron-sekolah', [SingkronController::class, 'sekolah'])->name('sekolah')->middleware('guest');
Route::get('/singkron-ptk', [SingkronController::class, 'ptk'])->name('ptk')->middleware('guest');
Route::get('/singkron-pd', [SingkronController::class, 'pd'])->name('pd')->middleware('guest');
Route::get('/singkron-rombel', [SingkronController::class, 'rombel'])->name('rombel')->middleware('guest');
Route::post('/dapo', [DapoController::class, 'update'])->name('dapo')->middleware('guest');
Route::get('/singkron', [SingkronController::class, 'index'])->middleware('guest');
Route::get('/indukrombel', [IndukrombelController::class, 'index'])->middleware('guest');
Route::get('/detailmurid', [IndukrombelController::class, 'detail'])->middleware('guest');
Route::get('/cetak', [IndukrombelController::class, 'cetak'])->middleware('guest');
Route::get('/review', [IndukrombelController::class, 'review'])->middleware('guest');
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/admin', [LoginController::class, 'admin'])->name('admin')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/admin', [LoginController::class, 'authadmin']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::resource('/kurikulum', KurikulumController::class)->middleware('guest');
Route::resource('/rombonganbelajar', RombonganbelajarController::class)->middleware('guest');
Route::resource('/pembelajaran', PembelajaranController::class)->middleware('guest');
Route::resource('/anggotarombel', AnggotarombelController::class)->middleware('guest');