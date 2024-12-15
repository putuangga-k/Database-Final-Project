<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembelian extends Model
{
    use HasFactory;

    protected $table = 'pembelians';

    protected $fillable = [
        'produk_id',
        'vendor_id',
        'tanggal_pembelian',
        'harga_produk',
        'quantitas_produk',
        'total_harga',
    ];

    /**
     * Relationship to Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    /**
     * Relationship to Vendor
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }
}