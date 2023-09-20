<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyidik extends Model
{
    use HasFactory;
    protected $fillable = ['data_pelanggar_id', 'name', 'nrp', 'pangkat', 'jabatan', 'tim', 'unit'];

    public function data_pelanggars()
    {
        return $this->hasOne(DataPelanggar::class, 'id', 'data_pelanggar_id');
    }

    public function pangkats()
    {
        return $this->hasOne(Pangkat::class, 'name', 'pangkat');
    }
}
