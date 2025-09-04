<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;

    public $incrementing = false; // jangan auto increment
    protected $keyType = 'string'; // kunci utama bukan integer

    protected $fillable = [
        'id'
    ];
    
}
