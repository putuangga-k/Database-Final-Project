<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stokis extends Model
{
    use HasFactory;

    protected $table = 'stokis'; // Pastikan nama tabel sesuai, jika tidak default 'stokis'
    protected $primaryKey = 'stokis_id'; // Menetapkan primary key
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nama_stokis',
        'no_hp',
        'lokasi',
        'product_id', 
    ];

    public function product()
    {
        return $this->belongsTo(Produk::class, 'product_id', 'produk_id');
    }
}
