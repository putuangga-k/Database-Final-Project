<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $primaryKey = 'vendor_id'; // Menetapkan primary key

    protected $fillable = [
        'vendor_nama',
        'contact_info',
        'lokasi',
        'produk_id',
    ];

    /**
     * Mendefinisikan hubungan dengan model Produk.
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}