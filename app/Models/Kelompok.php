<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;
    
    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

}
