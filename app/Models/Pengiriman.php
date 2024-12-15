<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengiriman extends Model
{
    use HasFactory;

    protected $table = 'pengirimans';

    protected $primaryKey = 'pengiriman_id';

    protected $fillable = [
        'stokis_id',
        'produk_id',
        'quantitas_produk',
        'tanggal_pengiriman',
    ];

    /**
     * Relasi ke model Stokis
     */
    public function stokis()
    {
        return $this->belongsTo(Stokis::class, 'stokis_id', 'stokis_id');
    }

    /**
     * Relasi ke model Produk
     */
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'produk_id');
    }
}
