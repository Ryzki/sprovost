<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Witness extends Model
{
    use HasFactory;

    protected $fillable = ['data_pelanggar_id', 'nama', 'pangkat', 'nrp', 'jabatan', 'kesatuan', 'warga_negara', 'agama', 'alamat', 'ttl', 'no_telp'];

    function agama(){
        return $this->hasOne(Agama::class, 'id', 'agama');
    }
}
