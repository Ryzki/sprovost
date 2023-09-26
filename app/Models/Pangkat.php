<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pangkat extends Model
{
    use HasFactory;
    protected $fillable = [ 'name' ];

    public function hasPelanggar()
    {
        return $this->belongsTo(DataPelanggar::class, 'id', 'pangkat');
    }
}

