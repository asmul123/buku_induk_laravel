<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matapelajaran extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'id',
        'nama',
        'pilihan_sekolah',
        'pilihan_buku',
        'pilihan_kepengawasan',
        'pilihan_evaluasi',
        'jurusan_id'
    ];
}
