<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = "produk";
    public $timestamps = true;
    
    protected $fillable = [
        'nama_produk',
        'berat',
        'satuan',
        'harga',
        'stok',
        'kategori_id',
        'gambar',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
