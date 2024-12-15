<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pusat extends Model
{
    use HasFactory;

    protected $primaryKey = 'pust_id'; // Menetapkan primary key

    protected $fillable = [
        'nama_pusat',
        'lokasi',
        'contact_info',
        'vendor_id',
        'produk_id',
    ];

    /**
     * Mendefinisikan hubungan dengan model Vendor.
     */
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    /**
     * Mendefinisikan hubungan dengan model Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}