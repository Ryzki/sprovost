<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WujudPerbuatan extends Model
{
    use HasFactory;
    protected $fillable = ['jenis_wp','keterangan_wp'];
}
