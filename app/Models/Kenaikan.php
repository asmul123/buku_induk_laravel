<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kenaikan extends Model
{
    use HasFactory;
    
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'sekolah_id',
        'anggotarombel_id',
        'rombonganbelajar_id',
        'status',
        'nama_kelas'
    ];

    public function anggotarombel(): BelongsTo
    {
        return $this->belongsTo(Anggotarombel::class);
    }

    public function rombonganbelajar(): BelongsTo
    {
        return $this->belongsTo(Rombonganbelajar::class);
    }

    public function getStatusLabel(): string
    {
        return match($this->status) {
            1 => 'Naik Kelas',
            2 => 'Tidak Naik Kelas',
            3 => 'Lulus',
            4 => 'Tidak Lulus',
            default => 'Tidak Diketahui'
        };
    }
}
