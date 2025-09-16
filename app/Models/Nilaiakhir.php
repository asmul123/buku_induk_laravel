<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Nilaiakhir extends Model
{
    use HasFactory;
     
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id',
        'sekolah_id',
        'pembelajaran_id',
        'anggotarombel_id',
        'kompetensi_id',
        'nilai'
    ];
    
    public function Pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function Anggotarombel()
    {
        return $this->belongsTo(Anggotarombel::class);
    }
    
    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }
}
