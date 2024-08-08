<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = true;
    protected $table = "customer";
    //protected $fillable = ['nama', 'email','hp'];
    protected $guarded = ['id'];

    public function Transaksi()
    {
        return $this->hasMany(Transaksi::class, 'customer_id');
    }
}
