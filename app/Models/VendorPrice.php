<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'produk_id',
        'vendor_id',
        'tanggal_berlaku',
        'harga_laku',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
}