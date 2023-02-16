<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DokumenPelanggar extends Model
{
    use HasFactory;

    protected $table = 'dokumen_pelanggarans';

    protected $fillable = [
        'data_pelanggar_id',
        'process_id',
        'sub_process_id',
        'status',
        'created_by'
    ];

    function sub_process(){
        return $this->hasMany(SubProcess::class, 'id', 'sub_process_id');
    }
}
