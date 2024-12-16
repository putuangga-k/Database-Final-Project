<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokisSold extends Model
{
    use HasFactory;

    // Jika nama tabel tidak mengikuti konvensi Laravel (plural), tentukan nama tabel
    protected $table = 'stokis_sold';

    // Jika primary key bukan 'id', tentukan primary key
    // protected $primaryKey = 'id';

    // Jika Anda tidak menggunakan timestamps, set false
    // public $timestamps = false;

    // Tentukan kolom yang bisa diisi (optional untuk read-only)
    protected $fillable = [
        'product_id',
        'stokis_id',
        'tanggal_sold',
        'harga',
    ];

    // Definisikan relasi jika diperlukan
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'produk_id');
    }

    public function stokis()
    {
        return $this->belongsTo(Stokis::class, 'stokis_id', 'stokis_id');
    }
}
