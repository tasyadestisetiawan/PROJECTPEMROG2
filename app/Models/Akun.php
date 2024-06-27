<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Akun extends Model
{
    public $timestamps = false;
    protected $table = "akun";
    protected $fillable = ['kode_akun', 'nama_akun'];
    //protected $guarded = ['id'];
}
