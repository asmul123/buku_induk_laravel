<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilaiakhir extends Model
{
    use HasFactory;
    
    public function Pembelajaran()
    {
        return $this->belongsTo(Pembelajaran::class);
    }

    public function Anggotarombel()
    {
        return $this->belongsTo(Anggotarombel::class);
    }
}
