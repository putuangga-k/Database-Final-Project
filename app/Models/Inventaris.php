<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $primaryKey = 'inventaris_id';

    protected $fillable = [
        'produk_id',
        'kuantitas',
    ];

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }    
}