<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyidik extends Model
{
    use HasFactory;
    protected $fillable = [ 'data_pelanggar_id' ,'name', 'nrp', 'pangkat', 'jabatan', 'kesatuan'];
}
