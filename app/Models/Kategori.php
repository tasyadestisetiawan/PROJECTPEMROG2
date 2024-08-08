<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Kategori extends Model
{
    public $timestamps = false;
    protected $table = "kategori";
    protected $fillable = [
        'nama_kategori',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function produk()
    {
        return $this->hasMany(Produk::class, 'kategori_id');
    }
}
