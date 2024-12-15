<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $primaryKey = 'produk_id'; // Mengatur primary key

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'category_id',
        'nama_produk',
        'deskripsi',
        'unit'
    ];

        // Relasi ke Category
        public function category()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }        
    
}
