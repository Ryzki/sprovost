<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SprinHistory extends Model
{
    use HasFactory;

    protected $fillable = [ 'data_pelanggar_id', 'isi_surat_perintah', 'created_by', 'no_sprin', 'type', 'no_nd_rehabpers', 'tgl_nd_rehabpers', 'unit_pemeriksa'];

    function user(){
        return $this->hasMany(User::class, 'id', 'created_by');
    }
}
