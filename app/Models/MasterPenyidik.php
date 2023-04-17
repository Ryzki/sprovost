<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPenyidik extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'nrp', 'pangkat', 'jabatan', 'tim', 'unit' ];
}
