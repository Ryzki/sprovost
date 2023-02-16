<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SprinHistory extends Model
{
    use HasFactory;

    protected $fillable = [ 'data_pelanggar_id', 'isi_surat_perintah', 'created_by'];

    function user(){
        return $this->hasMany(User::class, 'id', 'created_by');
    }
}
