<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'nama_kurikulum',
        'mulai_berlaku',
        'sistem_sks',
        'total_sks',
        'jenjangpendidikan_id',
        'jurusan_id'
    ];
    
    public function Jenjangpendidikan()
    {
        return $this->belongsTo(Jenjangpendidikan::class);
    }
    
    public function Jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }
}
