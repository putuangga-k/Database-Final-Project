<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mitra extends Model
{
    use HasFactory;

    protected $primaryKey = 'mitra_id'; // Set primary key

    protected $fillable = [
        'nama_mitra',
        'no_hp',
        'lokasi',
    ];
}