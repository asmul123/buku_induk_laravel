<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rombonganbelajar extends Model
{
    use HasFactory;    

    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'semester_id',
        'jurusan_id',
        'jurusan_sp_id',
        'kurikulum_id',
        'nama',
        'ptk_id',
        'tingkat',
        'jenisrombel_id',
        'kunci_nilai'
    ];
    
    public function Jenisrombel()
    {
        return $this->belongsTo(Jenisrombel::class);
    }
    
    public function Ptk()
    {
        return $this->belongsTo(Ptk::class);
    }
    
    public function Kurikulum()
    {
        return $this->belongsTo(Kurikulum::class);
    }
    
    public function Pembelajaran()
    {
        return $this->hasMany(Pembelajaran::class);
    }

    public function Anggotarombel()
    {
        return $this->hasMany(Anggotarombel::class);
    }
}
