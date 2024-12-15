<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Jika Anda menggunakan HasFactory, pastikan untuk mengimpor dan menggunakan trait tersebut
    // use HasFactory;

    protected $table = 'categories';

    // Menambahkan 'name' ke dalam properti $fillable
    protected $fillable = ['name'];

    // Relasi ke model Product (jika ada)
    public function products()
    {
        return $this->hasMany(Produk::class);
    }
}