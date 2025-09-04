<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ptk extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'nama',
        'nuptk',
        'nip',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'nik',
        'jenis_ptk_id',
        'agama_id',
        'status_kepegawaian_id',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kode_wilayah',
        'kode_pos',
        'no_hp',
        'email',
        'photo',
        'jabatan_ptk_id'
    ];
}
