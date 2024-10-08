<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;
    
    protected $table = 'transaksi';
    protected $fillable = [
        'customer_id',
        'produk_id',
        'user_id',
        'quantity',
        'berat',
        'harga_satuan',
        'total_harga',
        'tanggal'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class);
    }
    
}
