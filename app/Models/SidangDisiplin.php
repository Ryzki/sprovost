<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SidangDisiplin extends Model
{
    use HasFactory;
    protected $fillable = [ 'data_pelanggar_id', 'tgl_sidang', 'waktu_sidang', 'lokasi_sidang', 'hasil_sidang', 'hukuman_disiplin'];
}
