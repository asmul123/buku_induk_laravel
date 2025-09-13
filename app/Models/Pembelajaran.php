<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelajaran extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'semester_id',
        'rombonganbelajar_id',
        'ptk_id',
        'guru_pengajar_id',
        'matapelajaran_id',
        'nama_mata_pelajaran',
        'kelompok_id',
        'no_urut',
        'kkm',
        'is_dapodik',
        'rasio_p',
        'rasio_k',
        'induk_pembelajaran_id',
        'bobot_sumatif_materi',
        'bobot_sumatif_akhir'
    ];
    
    public function Ptk()
    {
        return $this->belongsTo(Ptk::class);
    }
    
    public function Matapelajaran()
    {
        return $this->belongsTo(Matapelajaran::class);
    }
    
    public function Rombonganbelajar()
    {
        return $this->belongsTo(Rombonganbelajar::class);
    }
}
