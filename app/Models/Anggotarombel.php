<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anggotarombel extends Model
{
    use HasFactory;

    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'semester_id',
        'rombonganbelajar_id',
        'pesertadidik_id'
    ];
    
    public function Pesertadidik()
    {
        return $this->belongsTo(Pesertadidik::class);
    }
}
