<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesertadidik extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'nama',
        'no_induk',
        'nisn',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'warga_negara',
        'agama_id',
        'status',
        'anak_ke',
        'alamat',
        'rt',
        'rw',
        'desa_kelurahan',
        'kecamatan',
        'kode_pos',
        'no_telp',
        'sekolah_asal',
        'ijazah_smp',
        'tanggal_ijazah_smp',
        'diterima_kelas',
        'diterima',
        'tanggal_meninggalkan',
        'alasan_meninggalkan',
        'no_ijazah_akhir',
        'tanggal_ijazah_akhir',
        'kode_wilayah',
        'email',
        'nama_ayah',
        'nama_ibu',
        'kerja_ayah',
        'kerja_ibu',
        'nama_wali',
        'alamat_wali',
        'telp_wali',
        'kerja_wali',
        'photo',
        'active'
    ];

    public function Agama()
    {
        return $this->belongsTo(Agama::class);
    }
}
