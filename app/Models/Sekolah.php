<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sekolah extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'nama',
        'nss',
        'npsn',
        'bentuk_pendidikan_id',
        'status_sekolah',
        'alamat',
        'kode_wilayah',
        'kode_pos',
        'no_telp',
        'no_fax',
        'email',
        'website',
        'lintang',
        'bujur',
        'desa_kelurahan',
        'kecamatan',
        'kabupaten',
        'provinsi'
    ];
}
